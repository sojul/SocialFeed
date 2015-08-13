<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InstagramTagProvider.
 */
class InstagramTagProvider extends AbstractProvider
{
    private $client;

    private $postFactory;

    private $tagName;

    /**
     * __construct.
     *
     * @param ClientInterface      $client
     * @param PostFactoryInterface $postFactory
     */
    public function __construct(ClientInterface $client, PostFactoryInterface $postFactory)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
    }

    /**
     * getResult.
     *
     * @param array $options
     */
    public function getResult(array $options = array())
    {
        $options = $this->resolveOptions($options);

        $feed = new Feed();

        $response = $this->client->get(sprintf('/v1/tags/%s/media/recent', $options['tag_name']), array(
            'query' => array(
                'max_tag_id' => $options['max_tag_id'],
            ),
        ));

        foreach ($response['data'] as $data) {
            $feed->addPost($this->postFactory->create($data));
        };

        $nextResultOptions = array();

        // extract pagination parameters
        if (isset($data['pagination']['next_max_id'])) {
            $nextResultOptions = array(
                'max_tag_id' => $data['pagination']['next_max_id'],
            );
        }

        return new ResultSet($feed, $nextResultOptions);
    }

    public function getName()
    {
        return 'instagram';
    }

    /**
     * configureOptionResolver.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('tag_name');

        $resolver->setDefaults(array(
            'max_tag_id' => null,
        ));
    }
}
