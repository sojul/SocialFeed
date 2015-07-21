<?php

namespace Lns\SocialFeed\Model;

class ResultSet implements ResultSetInterface
{
    protected $nextResultSetOptions = array();
    protected $iterator;

    /**
     * @param FeedInterface $feed
     * @param array         $nextResultSetOptions
     */
    public function __construct(FeedInterface $feed, array $nextResultSetOptions = array())
    {
        $this->iterator = $feed->getIterator();
        $this->nextResultSetOptions = $nextResultSetOptions;
    }

    public function getNextResultSetOptions()
    {
        return $this->nextResultSetOptions;
    }

    public function hasNextResultSet()
    {
        return !empty($this->nextResultSetOptions);
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}
