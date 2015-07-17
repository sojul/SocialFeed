<?php

namespace Lns\SocialFeed\Model;

interface ResultSetInterface extends \IteratorAggregate
{
    public function __construct(FeedInterface $feed, array $nextResultOptions = array());
    public function getResult();
    public function getNextResultOptions();
    public function hasNextResult();
}

