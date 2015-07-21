<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwitterSearchApiProvider extends AbstractProvider
{
    private $client;

    public function __construct(ClientInterface $client, PostFactoryInterface $postFactory)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
    }

    public function getResult(array $options = array())
    {
        $options = $this->resolveOptions($options);

        $result = $this->client->get('/1.1/search/tweets.json', array(
            'query' => array(
                'q' => $options['query'],
                'since_id' => $options['since_id'],
            ), )
        );

        $feed = new Feed();

        foreach ($result['statuses'] as $status) {
            $feed->addPost($this->postFactory->create($status));
        }

        $nextResultOptions = array();

        if (isset($result['search_metadata'])) {
            $nextResultOptions = array(
                'since_id' => $result['search_metadata']['max_id_str'],
            );
        }

        return new ResultSet($feed, $nextResultOptions);
    }

    public function getName()
    {
        return 'twitter_search_api';
    }

    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('query');

        $resolver->setDefaults(array(
            'since_id' => null,
        ));
    }
}
