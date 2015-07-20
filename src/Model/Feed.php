<?php

namespace Lns\SocialFeed\Model;

class Feed implements \IteratorAggregate, FeedInterface
{
    protected $feedArray = array();

    /**
     * addPost
     *
     * @param PostInterface $post
     * @return self
     */
    public function addPost(PostInterface $post)
    {
        $this->feedArray[$post->getUniqueIdentifier()] = $post;
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
     * contains
     *
     * @param PostInterface $item
     * @return bool
     */
    public function contains(PostInterface $item) {
        return in_array($item->getUniqueIdentifier(), array_keys($this->feedArray));
    }

    /**
     * @{inheritDoc}
     */
    public function getIterator() {
        return new \ArrayIterator($this->feedArray);
    }

    public function merge(FeedInterface $feed)
    {
        foreach($feed as $post) {
            $this->addPost($post);
        }

        return $this;
    }

    public function sort()
    {
        uasort($this->feedArray, function($a, $b) {
            return $a->getCreatedAt() < $b->getCreatedAt();
        });

        return $this;
    }
}
