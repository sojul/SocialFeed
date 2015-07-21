<?php

namespace Lns\SocialFeed\Model;

interface ResultSetInterface extends \IteratorAggregate
{
    public function __construct(FeedInterface $feed, array $nextResultSetOptions = array());
    public function getNextResultSetOptions();
    public function hasNextResultSet();
}
