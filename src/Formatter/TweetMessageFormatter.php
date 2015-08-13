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

use Lns\SocialFeed\Model\ReferenceType;

class TweetMessageFormatter extends AbstractMessageFormatter
{
    protected function formatMessagePart($messagePart)
    {
        $reference = $messagePart['reference'];

        if (!$reference) {
            return $messagePart['text'];
        }

        $data = $reference->getData();

        switch ($reference->getType()) {
        case ReferenceType::USER:
            return $this->createLinkString('https://twitter.com/'.$data['screen_name'], $messagePart['text']);
            break;
        case ReferenceType::HASHTAG:
            return $this->createLinkString('https://twitter.com/hashtag/'.$data['text'], $messagePart['text']);
            break;
        case ReferenceType::VIDEO:
        case ReferenceType::MEDIA:
        case ReferenceType::URL:
            return $this->createLinkString($data['expanded_url'], $data['display_url']);
            break;
        default:
            return;
            break;
        }
    }
}
