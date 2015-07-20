<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;
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

    public function getResult(array $options = array()) {
        $options = $this->resolveOptions($options);

        $feed = new Feed();

        $response = $this->client->get(sprintf('/v1/tags/%s/media/recent', $options['tag_name']));

        foreach($response['data'] as $data) {
            $feed->addPost($this->postFactory->create($data));
        };

        $nextResultOptions = array();

        // extract pagination parameters
        if(isset($data['pagination']['next_max_id'])) {
            $nextResultOptions = array(
                'max_tag_id' => $data['pagination']['next_max_id']
            );
        }

        return new ResultSet($feed, $nextResultOptions);
    }

    public function getName()
    {
        return 'instagram';
    }

    public function configureOptionResolver(OptionsResolver &$resolver) {
        $resolver->setRequired('tag_name');
    }
}
