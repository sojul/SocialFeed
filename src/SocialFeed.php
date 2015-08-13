<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed;

use Lns\SocialFeed\Iterator\SourceIterator;
use Lns\SocialFeed\Model\PostInterface;

class SocialFeed implements \Iterator
{
    protected $sourceIterators = array();
    protected $current = null;
    protected $position = 0;

    public function addSource(SourceInterface $source)
    {
        $this->addSourceIterator(new SourceIterator($source));

        return $this;
    }

    public function addSourceIterator(SourceIterator $sourceIterator)
    {
        $this->sourceIterators[] = $sourceIterator;

        return $this;
    }

    public function current()
    {
        return $this->current;
    }

    public function next()
    {
        // find the next most recent element
        $mostRecentPostIterator = null;
        $mostRecentPost = null;

        foreach ($this->sourceIterators as $sourceIterator) {
            if (
                !$sourceIterator->valid() ||
                $mostRecentPost !== null && $this->comparePost($sourceIterator->current(), $mostRecentPost)
            ) {
                continue;
            }

            $mostRecentPost = $sourceIterator->current();
            $mostRecentPostIterator = $sourceIterator;
        }

        // move the mostRecentPostIterator to the next element
        if ($mostRecentPostIterator !== null) {
            $mostRecentPostIterator->next();
        }

        $this->current = $mostRecentPost;
        ++$this->position;
    }

    protected function comparePost(PostInterface $post1, PostInterface $post2)
    {
        return $post1->getCreatedAt() < $post2->getCreatedAt();
    }

    public function valid()
    {
        return $this->current !== null;
    }

    public function key()
    {
        return $this->position;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->current = null;

        foreach ($this->sourceIterators as $sourceIterator) {
            $sourceIterator->rewind();
        }

        $this->next();
    }
}
