<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Fixer;

use Symfony\CS\DocBlock\DocBlock;
use Symfony\CS\FixerInterface;
use Symfony\CS\Tokenizer\Tokens;

/**
 * PhpDocFullyQualifiedParamHintFixer.
 */
class PhpDocFullyQualifiedParamHintFixer implements FixerInterface
{
    private $regex;
    private $regexCommentLine;

    public function __construct()
    {
        // e.g. @param <hint> <$var>
        $paramTag = '(?P<tag>param)\s+(?P<hint>[^$]+?)\s+(?P<var>&?\$[^\s]+)';
        // e.g. @return <hint>
        $otherTags = '(?P<tag2>return|throws|var|type)\s+(?P<hint2>[^\s]+?)';
        // optional <desc>
        $desc = '(?:\s+(?P<desc>.*)|\s*)';
        $this->regex = '/^(?P<indent>(?: {4})*) \* @(?:'.$paramTag.'|'.$otherTags.')'.$desc.'$/';
        $this->regexCommentLine = '/^(?P<indent>(?: {4})*) \*(?! @)(?:\s+(?P<desc>.+))(?<!\*\/)$/';
    }

    /**
     * {@inheritdoc}
     */
    public function fix(\SplFileInfo $file, $content)
    {
        $tokens = Tokens::fromCode($content);

        $namespaceDeclarations = $this->getNamespaceDeclarations($tokens);
        $useDeclarationsIndexes = $tokens->getImportUseIndexes();
        $useDeclarations = $this->getNamespaceUseDeclarations($tokens, $useDeclarationsIndexes);
        $contentWithoutUseDeclarations = $this->generateCodeWithoutPartials($tokens, array_merge($namespaceDeclarations, $useDeclarations));

        $this->resolvePhpDocParamTypes($tokens, $useDeclarations, $namespaceDeclarations);

        return $tokens->generateCode();
    }

    /**
     * resolvePhpDocParamTypes.
     *
     * @param $tokens
     * @param $useDeclarations
     * @param $namespaceDeclarations
     */
    private function resolvePhpDocParamTypes($tokens, $useDeclarations, $namespaceDeclarations)
    {
        foreach ($tokens->findGivenKind(T_DOC_COMMENT) as $token) {
            $doc = new DocBlock($token->getContent());
            $annotations = $doc->getAnnotationsOfType('param');
            if (empty($annotations)) {
                continue;
            }
            foreach ($annotations as $annotation) {
                $line = $doc->getLine($annotation->getStart());

                $matches = $this->getMatches($line->getContent());
                if (null === $matches) {
                    continue;
                }

                if (!isset($matches['hint'])) {
                    continue;
                }

                if (substr($matches['hint'], 0, 1) === '\\') {
                    continue;
                }

                if (false !== strpos($matches['hint'], '\\')) {
                    continue;
                }

                $resolved = false;

                // resolve hint
                foreach ($useDeclarations as $useDeclaration) {
                    // replace hint by useDeclaration fullname if it match
                    if (in_array($matches['hint'], array($useDeclaration['shortName'], $useDeclaration['aliased']), true)) {
                        $line->setContent(str_replace($matches['hint'], $useDeclaration['fullName'], $line->getContent()));
                        $resolved = true;
                        break;
                    }
                }

                if ($resolved) {
                    continue;
                }

                // add namespace if needed
                $namespace = $namespaceDeclarations[0]['name'];

                if (false === strpos($matches['hint'], '\\')) {
                    $line->setContent(str_replace($matches['hint'], $namespace.'\\'.$matches['hint'], $line->getContent()));
                }
            }

            $token->setContent($doc->getContent());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        // should be run after the MultipleUseFixer
        return 0;
    }

    /**
     * supports.
     *
     * @param SplFileInfo $file
     */
    public function supports(\SplFileInfo $file)
    {
        return 'php' === pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    }

    public function getLevel()
    {
        return FixerInterface::NONE_LEVEL;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'phpdoc @param types must be fully resolved';
    }

    public function getName()
    {
        return 'php_doc_fully_qualified_param_hint';
    }

    /**
     * getNamespaceDeclarations.
     *
     * @param Tokens $tokens
     */
    private function getNamespaceDeclarations(Tokens $tokens)
    {
        $namespaces = array();

        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(T_NAMESPACE)) {
                continue;
            }

            $declarationEndIndex = $tokens->getNextTokenOfKind($index, array(';', '{'));

            $namespaces[] = array(
                'end' => $declarationEndIndex,
                'name' => trim($tokens->generatePartialCode($index + 1, $declarationEndIndex - 1)),
                'start' => $index,
            );
        }

        return $namespaces;
    }

    /**
     * getNamespaceUseDeclarations.
     *
     * @param Tokens $tokens
     * @param array  $useIndexes
     */
    private function getNamespaceUseDeclarations(Tokens $tokens, array $useIndexes)
    {
        $uses = array();

        foreach ($useIndexes as $index) {
            $declarationEndIndex = $tokens->getNextTokenOfKind($index, array(';'));
            $declarationContent = $tokens->generatePartialCode($index + 1, $declarationEndIndex - 1);

            // ignore multiple use statements like: `use BarB, BarC as C, BarD;`
            // that should be split into few separate statements
            if (false !== strpos($declarationContent, ',')) {
                continue;
            }

            $declarationParts = preg_split('/\s+as\s+/i', $declarationContent);

            if (1 === count($declarationParts)) {
                $fullName = $declarationContent;
                $declarationParts = explode('\\', $fullName);
                $shortName = end($declarationParts);
                $aliased = false;
            } else {
                $fullName = $declarationParts[0];
                $shortName = $declarationParts[1];
                $declarationParts = explode('\\', $fullName);
                $aliased = $shortName !== end($declarationParts);
            }

            $shortName = trim($shortName);

            $uses[$shortName] = array(
                'aliased' => $aliased,
                'end' => $declarationEndIndex,
                'fullName' => trim($fullName),
                'shortName' => $shortName,
                'start' => $index,
            );
        }

        return $uses;
    }

    /**
     * Get all matches.
     *
     * @param string $line
     * @param bool   $matchCommentOnly
     *
     * @return string[]|null
     */
    private function getMatches($line, $matchCommentOnly = false)
    {
        if (preg_match($this->regex, $line, $matches)) {
            if (!empty($matches['tag2'])) {
                $matches['tag'] = $matches['tag2'];
                $matches['hint'] = $matches['hint2'];
            }

            return $matches;
        }
        if ($matchCommentOnly && preg_match($this->regexCommentLine, $line, $matches)) {
            $matches['tag'] = null;
            $matches['var'] = '';
            $matches['hint'] = '';

            return $matches;
        }
    }

    /**
     * generateCodeWithoutPartials.
     *
     * @param Tokens $tokens
     * @param array  $partials
     */
    private function generateCodeWithoutPartials(Tokens $tokens, array $partials)
    {
        $content = '';
        foreach ($tokens as $index => $token) {
            $allowToAppend = true;
            foreach ($partials as $partial) {
                if ($partial['start'] <= $index && $index <= $partial['end']) {
                    $allowToAppend = false;
                    break;
                }
            }
            if ($allowToAppend) {
                $content .= $token->getContent();
            }
        }

        return $content;
    }
}
