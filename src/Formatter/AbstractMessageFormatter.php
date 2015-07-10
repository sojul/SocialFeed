<?php

namespace Lns\SocialFeed\Formatter;

use Lns\SocialFeed\Model\ReferenceType;

abstract class AbstractMessageFormatter implements MessageFormatterInterface
{
    public function format($message, array $references = array())
    {
        // sort references by start indice
        // for testing issue we need to add @
        // @see https://github.com/phpspec/prophecy/issues/161
        @uasort($references, function($a, $b) {
            return ($a->getStartIndice() > $b->getStartIndice());
        });

        $messageParts = $this->buildMessageParts($message, $references);

        // build message
        $formattedMessageParts = [];

        foreach($messageParts as $messagePart) {
            if(is_null($messagePart)) {
                continue;
            }

            $formattedMessageParts[] = $this->formatMessagePart($messagePart);
        }

        return join($formattedMessageParts);
    }

    protected function buildMessageParts($message, $references, $offset = 0) {

        $messageParts = [];

        // get first reference
        $reference = array_shift($references);

        if(!$reference) {
            return [
                $this->buildMessagePart($message, 0, mb_strlen($message))
            ];
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

        foreach($this->buildMessageParts($message, $references, $reference->getEndIndice()) as $messagePart) {
            $messageParts[] = $messagePart;
        };

        return $messageParts;
    }

    protected function buildMessagePart($message, $start, $end, $reference = null) {
        if($start == $end) {
            return;
        }

        return array(
            'text'      => mb_substr($message, $start, $end - $start, "UTF-8"),
            'reference' => $reference,
        );
    }

    protected function createLinkString($href, $display, $target = "_blank") {
        return sprintf('<a href="%s" target="%s">%s</a>', $href, $target, $display);
    }

    protected function autoLink($message) {
        $regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
        return preg_replace_callback($regex, function ($matches) {
            return $this->createLinkString($matches[0], $matches[0]);
        }, $message);
    }
}
