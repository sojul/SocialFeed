<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Factory\PostFactory;

class TwitterSearchApiSource implements SourceInterface
{
    private $twitterApiClient;
    private $query;

    public function __construct(TwitterApiClient $twitterApiClient, PostFactory $postFactory)
    {
        $this->twitterApiClient = $twitterApiClient;
        $this->postFactory = $postFactory;
    }

    public function setQuery() {
        $this->query = $query;
    }

    public function getFeed() {

        $getFields = http_build_query([
            'q' => $this->query
        ]);

        $response = $this->twitterApiClient
            ->get('test');

        $result = $response->json();

        foreach($result['statuses'] as $status) {
            var_export($status); die();
        }
    }
}
