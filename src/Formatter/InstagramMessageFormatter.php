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
 * InstagramMessageFormatter.
 */
class InstagramMessageFormatter extends AbstractMessageFormatter
{
    /**
     * autoLink.
     *
     * @param $message
     */
    protected function autoLink($message)
    {
        $message = parent::autoLink($message);

        $message = preg_replace_callback('/@(\w+)/u', function ($matches) {
            return $this->createLinkString('https://instagram.com/'.$matches[1].'/', $matches[0]);
        }, $message);

        $message = preg_replace_callback('/#(\w+)/u', function ($matches) {
            return $this->createLinkString('https://instagram.com/explore/tags/'.$matches[1], $matches[0]);
        }, $message);

        return $message;
    }
}
