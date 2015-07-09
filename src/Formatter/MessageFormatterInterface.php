<?php

namespace Lns\SocialFeed\Formatter;

interface MessageFormatterInterface
{
    public function format($message, array $references = array());
}
