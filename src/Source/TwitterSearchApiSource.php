<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Factory\PostFactory;

class TwitterSearchApiSource implements SourceInterface
{
    private $twitterApiClient;
    private $query;

    public function __construct(TwitterApiClient $twitterApiClient, PostFactory $postFactory, $query)
    {
        $this->twitterApiClient = $twitterApiClient;
        $this->postFactory = $postFactory;
        $this->query = $query;
    }

    public function getFeed() {

        $response = $this->twitterApiClient
            ->get($this->query);

        $result = $response;

        $feed = new Feed();

        foreach($result['statuses'] as $status) {
            $feed->addPost($this->postFactory->createFromTwitterApiData($status));
        }

        return $feed;
    }
}
