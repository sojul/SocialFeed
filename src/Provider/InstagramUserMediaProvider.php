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
use Lns\SocialFeed\Model\Pagination\Token;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * InstagramUserMediaProvider.
 */
class InstagramUserMediaProvider extends AbstractProvider
{
    private $client;
    private $postFactory;

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
     * {@inheritdoc}
     */
    public function get(array $parameters = array())
    {
        $parameters = $this->resolveParameters($parameters);

        $response = $this->client->get(sprintf('/v1/users/%s/media/recent', $parameters['user_id']), array(
            'query' => array(
                'max_tag_id' => $parameters['max_tag_id'],
            ),
        ));

        $nextResultOptions = array();

        return new ResultSet(
            $this->getFeed($response),
            $parameters,
            $this->getNextPaginationToken($response)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'instagram';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('user_id');

        $resolver->setDefaults(array(
            'max_tag_id' => null,
        ));
    }

    protected function getFeed($response)
    {
        $feed = new Feed();

        foreach ($response['data'] as $postData) {
            $feed->addPost($this->postFactory->create($postData));
        }

        return $feed;
    }

    protected function getNextPaginationToken($response)
    {
        if (!isset($response['pagination']['next_max_id'])) {
            return;
        }

        return new Token(array(
            'max_tag_id' => $response['pagination']['next_max_id'],
        ));
    }
}