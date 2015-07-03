<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\Feed;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstagramTagProvider extends AbstractProvider
{
    private $client;

    private $postFactory;

    private $tagName;

    public function __construct(ClientInterface $client, PostFactoryInterface $postFactory)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
    }

    public function getFeed(array $options = array()) {
        $options = $this->resolveOptions($options);

        $feed = new Feed();

        $response = $this->client->get(sprintf('/v1/tags/%s/media/recent', $options['tag_name']));

        foreach($response['data'] as $data) {
            $feed->addPost($this->postFactory->createInstagramPostFromApiData($data));
        };

        return $feed;
    }

    public function getName()
    {
        return 'instagram';
    }

    public function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('tag_name');
    }
}
