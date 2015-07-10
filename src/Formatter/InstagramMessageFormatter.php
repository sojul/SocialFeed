<?php

namespace Lns\SocialFeed\Formatter;

class InstagramMessageFormatter extends AbstractMessageFormatter
{
    protected function autoLink($message) {
        $message = parent::autoLink($message);

        $message = preg_replace_callback('/@(\w+)/u', function($matches) {
            return $this->createLinkString('https://instagram.com/' . $matches[1] . '/', $matches[0]);
        }, $message);

        $message = preg_replace_callback('/#(\w+)/u', function($matches) {
            return $this->createLinkString('https://instagram.com/explore/tags/' . $matches[1], $matches[0]);
        }, $message);

        return $message;
    }
}
