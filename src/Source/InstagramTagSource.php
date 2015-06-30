<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\Feed;

class InstagramTagSource implements SourceInterface
{
    private $client;

    private $postFactory;

    private $tagName;

    public function __construct(ClientInterface $client, PostFactoryInterface $postFactory, $tagName)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
        $this->tagName = $tagName;
    }

    public function getFeed() {
        $feed = new Feed();

        $response = $this->client->get(sprintf('/v1/tags/%s/media/recent', $this->tagName));

        foreach($response['data'] as $data) {
            $feed->addPost($this->postFactory->createInstagramPostFromApiData($data));
        };

        return $feed;
    }
}
