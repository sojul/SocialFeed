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
 * TwitterSearchApiProvider.
 */
class TwitterSearchApiProvider extends AbstractProvider
{
    private $client;

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

        $response = $this->client->get('/1.1/search/tweets.json', array(
            'query' => array(
                'q' => $parameters['query'],
                'max_id' => $parameters['max_id'],
            ),
        ));

        $feed = $this->getFeed($response);

        return new ResultSet(
            $this->getFeed($response),
            $parameters,
            $this->getNextPaginationToken($response)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('query');

        $resolver->setDefaults(array(
            'max_id' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_search_api';
    }

    protected function getNextPaginationToken($response)
    {
        if (!isset($result['search_metadata'])) {
            return;
        }

        $parameters = $this->extractUrlParameters($response['search_metadata']['next_results']);

        return new Token(array(
            'max_id' => $parameters['max_id'],
        ));
    }

    protected function getFeed($response)
    {
        $feed = new Feed();

        foreach ($response['statuses'] as $postData) {
            $feed->addPost($this->postFactory->create($postData));
        }

        return $feed;
    }
}
