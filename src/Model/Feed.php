<?php

namespace Lns\SocialFeed\Model;

use PhpCollection\Map;

class Feed extends Map
{
    public function addPost(PostInterface $post)
    {
        $this->set($post->getIdentifier(), $post);
        return $this;
    }
}
