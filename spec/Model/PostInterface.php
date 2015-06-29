<?php

namespace Lns\SocialFeed\Model;

interface PostInterface
{
    public function getIdentifier();
    public function getMessage();
    public function getAuthor();
}
