<?php

namespace Lns\SocialFeed\Formatter;

use Lns\SocialFeed\Model\ReferenceType;

abstract class AbstractMessageFormatter implements MessageFormatterInterface
{
    public function format($message, array $references = array())
    {
        $messageParts = array();

        // sort references by start indice
        // for testing issue we need to add @
        // @see https://github.com/phpspec/prophecy/issues/161
        @uasort($references, function($a, $b) {
            return ($a->getStartIndice() > $b->getStartIndice());
        });

        $start = 0;

        // build message parts
        foreach($references as $reference) {
            $end = $reference->getStartIndice();
            $messageParts[] = $this->buildMessagePart($message, $start, $end);
            $start = $end;
            $end = $reference->getEndIndice();
            $messageParts[] = $this->buildMessagePart($message, $start, $end, $reference);
            $start = $end;
        }

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
}
