<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;

class TwitterSearchApiSource implements SourceInterface
{
    private $twitterApiClient;
    private $query;

    public function __construct(ClientInterface $twitterApiClient, PostFactoryInterface $postFactory, $query)
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
            $feed->addPost($this->postFactory->createTweetFromApiData($status));
        }

        return $feed;
    }
}
