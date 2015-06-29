<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Client\InstagramApiClient;
use Lns\SocialFeed\Factory\PostFactory;
use Lns\SocialFeed\Model\Feed;

class InstagramTagSource implements SourceInterface
{
    private $client;

    private $postFactory;

    private $tagName;

    public function __construct(InstagramApiClient $client, PostFactory $postFactory, $tagName)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
        $this->tagName = $tagName;
    }

    public function getFeed() {
        $feed = new Feed();

        $response = $this->client->get(sprintf('/v1/tags/%s/media/recent', $this->tagName));

        foreach($response['data'] as $data) {
            $feed->addPost($this->postFactory->createFromInstagramApiData($data));
        };

        return $feed;
    }
}
