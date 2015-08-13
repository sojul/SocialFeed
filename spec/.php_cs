# vi:syntax=php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::NONE_LEVEL)
    ->addCustomFixer(new Lns\SocialFeed\Fixer\PhpDocFullyQualifiedParamHintFixer())
    ->fixers(
        [
            'php_doc_fully_qualified_param_hint',
        ]
    )
    ->finder($finder)
;
