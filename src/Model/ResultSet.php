<?php

namespace Lns\SocialFeed\Model;

class ResultSet implements ResultSetInterface
{
    protected $feed;
    protected $nextResultOptions = array();

    /**
     * @param FeedInterface $feed
     * @param array $nextResultOptions
     */
    public function __construct(FeedInterface $feed, array $nextResultOptions = array())
    {
        $this->feed = $feed;
        $this->nextResultOptions = $nextResultOptions;
    }

    public function getResult()
    {
        return $this->feed;
    }

    public function getNextResultOptions()
    {
        return $this->nextResultOptions;
    }

    public function hasNextResult()
    {
        return !empty($this->nextResultOptions);
    }

    public function getIterator() {
        return $this->feed;
    }
}
