<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwitterSearchApiSource extends AbstractSource
{
    private $twitterApiClient;

    public function __construct(ClientInterface $twitterApiClient, PostFactoryInterface $postFactory)
    {
        $this->twitterApiClient = $twitterApiClient;
        $this->postFactory = $postFactory;
    }

    public function getFeed(array $options = array()) {

        $options = $this->resolveOptions($options);

        $response = $this->twitterApiClient
            ->get($options['query']);

        $result = $response;

        $feed = new Feed();

        foreach($result['statuses'] as $status) {
            $feed->addPost($this->postFactory->createTweetFromApiData($status));
        }

        return $feed;
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('query');
    }
}
