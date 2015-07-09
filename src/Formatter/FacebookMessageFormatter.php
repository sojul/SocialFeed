<?php

namespace Lns\SocialFeed\Formatter;

use Lns\SocialFeed\Model\ReferenceType;

class FacebookMessageFormatter extends AbstractMessageFormatter
{
    protected function formatMessagePart($messagePart) {
        $reference = $messagePart['reference'];

        if(!$reference) {
            return $messagePart['text'];
        }

        $data = $reference->getData();

        switch($reference->getType()) {
        case ReferenceType::PAGE:
        case ReferenceType::GROUP:
        case ReferenceType::USER:
            return $this->createLinkString('https://www.facebook.com/'. $data['id'], $messagePart['text']);
            break;
        default:
            return null;
            break;
        }
    }
}
