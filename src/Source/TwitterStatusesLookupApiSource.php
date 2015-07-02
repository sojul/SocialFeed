<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwitterStatusesLookupApiSource extends AbstractSource
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
            ->get('/1.1/statuses/lookup.json?id=' . join($options['ids'], ','));

        $result = $response;

        $feed = new Feed();

        foreach($result as $status) {
            $feed->addPost($this->postFactory->createTweetFromApiData($status));
        }

        return $feed;
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('ids');
    }
}
