<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Model;

/**
 * Feed.
 */
class Feed implements \IteratorAggregate, FeedInterface
{
    protected $feedArray = array();

    /**
     * addPost.
     *
     * @param PostInterface $post
     *
     * @return self
     */
    public function addPost(PostInterface $post)
    {
        $this->feedArray[$post->getUniqueIdentifier()] = $post;

        return $this;
    }

    /**
     * getPost.
     *
     * @param string|int $identifier
     *
     * @return PostInterface $post
     */
    public function getPost($identifier)
    {
        return $this->feedArray[$identifier];
    }

    /**
     * contains.
     *
     * @param PostInterface $item
     *
     * @return bool
     */
    public function contains(PostInterface $item)
    {
        return in_array($item->getUniqueIdentifier(), array_keys($this->feedArray), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->feedArray);
    }

    /**
     * merge.
     *
     * @param FeedInterface $feed
     */
    public function merge(FeedInterface $feed)
    {
        foreach ($feed as $post) {
            $this->addPost($post);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        array_values($this->feedArray)[0];
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        array_pop(array_values($this->feedArray));
    }

    public function sort()
    {
        uasort($this->feedArray, function ($a, $b) {
            return $a->getCreatedAt() < $b->getCreatedAt();
        });

        return $this;
    }
}
