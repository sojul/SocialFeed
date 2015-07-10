<?php

namespace Lns\SocialFeed\Formatter;

use Lns\SocialFeed\Model\ReferenceType;
use Lns\SocialFeed\Model\Reference;

class FacebookMessageFormatter extends AbstractMessageFormatter
{
    protected function formatMessagePart($messagePart) {
        $reference = $messagePart['reference'];

        if(!$reference) {
            return $this->autoLink($messagePart['text']);
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

    protected function autoLink($message) {
        $message = parent::autoLink($message);

        return preg_replace_callback('/#(\w+)/', function($matches) {
            return $this->createLinkString('https://www.facebook.com/hashtag/' . $matches[1], $matches[0]);
        }, $message);
    }
}
