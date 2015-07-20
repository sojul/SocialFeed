<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwitterStatusesLookupApiProvider extends AbstractProvider
{
    private $twitterApiClient;

    public function __construct(ClientInterface $twitterApiClient, PostFactoryInterface $postFactory)
    {
        $this->twitterApiClient = $twitterApiClient;
        $this->postFactory = $postFactory;
    }

    public function getResult(array $options = array()) {

        $options = $this->resolveOptions($options);

        $response = $this->twitterApiClient
            ->get('/1.1/statuses/lookup.json?id=' . join($options['ids'], ','));

        $result = $response;

        $feed = new Feed();

        foreach($result as $status) {
            $feed->addPost($this->postFactory->create($status));
        }

        return new ResultSet($feed);
    }

    public function getName()
    {
        return 'twitter_status_lookup_api';
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('ids');
    }
}
