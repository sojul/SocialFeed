<?php

namespace Lns\SocialFeed\Model;

use PhpCollection\Map;

class Feed implements \IteratorAggregate
{
    protected $feedArray;

    public function __construct() {
        $this->feedArray = array();
    }

    /**
     * addPost
     *
     * @param PostInterface $post
     * @return self
     */
    public function addPost(PostInterface $post)
    {
        $this->feedArray[$post->getIdentifier()] = $post;
        return $this;
    }

    /**
     * getPost
     *
     * @param string|int $identifier
     * @return PostInterface $post
     */
    public function getPost($identifier)
    {
        return $this->feedArray[$identifier];
    }

    /**
     * @{inheritDoc}
     */
    public function getIterator() {
        return new \ArrayIterator($this->feedArray);
    }
}
