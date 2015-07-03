<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwitterSearchApiProvider extends AbstractProvider
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
            ->get('/1.1/search/tweets.json?q=' . $options['query']);

        $result = $response;

        $feed = new Feed();

        foreach($result['statuses'] as $status) {
            $feed->addPost($this->postFactory->createTweetFromApiData($status));
        }

        return $feed;
    }

    public function getName()
    {
        return 'twitter_search_api';
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('query');
    }
}
