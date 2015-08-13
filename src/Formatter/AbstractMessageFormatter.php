<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Formatter;

/**
 * AbstractMessageFormatter.
 */
abstract class AbstractMessageFormatter implements MessageFormatterInterface
{
    /**
     * format.
     *
     * @param $message
     * @param array $references
     */
    public function format($message, array $references = array())
    {
        // sort references by start indice
        // for testing issue we need to add @
        // @see https://github.com/phpspec/prophecy/issues/161
        @uasort($references, function ($a, $b) {
            return ($a->getStartIndice() > $b->getStartIndice());
        });

        $messageParts = $this->buildMessageParts($message, $references);

        // build message
        $formattedMessageParts = array();

        foreach ($messageParts as $messagePart) {
            if (is_null($messagePart)) {
                continue;
            }

            $formattedMessageParts[] = $this->formatMessagePart($messagePart);
        }

        return implode($formattedMessageParts);
    }

    /**
     * formatMessagePart.
     *
     * @param $messagePart
     */
    protected function formatMessagePart($messagePart)
    {
        $reference = $messagePart['reference'];

        if (!$reference) {
            return $this->autoLink($messagePart['text']);
        }
    }

    /**
     * buildMessageParts.
     *
     * @param $message
     * @param $references
     * @param $offset
     */
    protected function buildMessageParts($message, $references, $offset = 0)
    {
        $messageParts = array();

        // get first reference
        $reference = array_shift($references);

        if (!$reference) {
            return array(
                $this->buildMessagePart($message, 0, mb_strlen($message)),
            );
        }

        $messageParts[] = $this->buildMessagePart(
            $message,
            0,
            $reference->getStartIndice() - $offset
        );

        $messageParts[] = $this->buildMessagePart(
            $message,
            $reference->getStartIndice() - $offset,
            $reference->getEndIndice() - $offset,
            $reference
        );

        $message = mb_substr($message, $reference->getEndIndice() - $offset);

        foreach ($this->buildMessageParts($message, $references, $reference->getEndIndice()) as $messagePart) {
            $messageParts[] = $messagePart;
        };

        return $messageParts;
    }

    /**
     * buildMessagePart.
     *
     * @param $message
     * @param $start
     * @param $end
     * @param $reference
     */
    protected function buildMessagePart($message, $start, $end, $reference = null)
    {
        if ($start === $end) {
            return;
        }

        return array(
            'text' => mb_substr($message, $start, $end - $start, 'UTF-8'),
            'reference' => $reference,
        );
    }

    /**
     * createLinkString.
     *
     * @param $href
     * @param $display
     * @param $target
     */
    protected function createLinkString($href, $display, $target = '_blank')
    {
        return sprintf('<a href="%s" target="%s">%s</a>', $href, $target, $display);
    }

    /**
     * autoLink.
     *
     * @param $message
     */
    protected function autoLink($message)
    {
        $regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';

        return preg_replace_callback($regex, function ($matches) {
            return $this->createLinkString($matches[0], $matches[0]);
        }, $message);
    }
}
