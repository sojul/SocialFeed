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
 * YoutubePlaylistProvider.
 */
class YoutubePlaylistProvider extends AbstractProvider
{
    private $youtubeApiClient;

    /**
     * __construct.
     *
     * @param ClientInterface      $youtubeApiClient
     * @param PostFactoryInterface $postFactory
     */
    public function __construct(ClientInterface $youtubeApiClient, PostFactoryInterface $postFactory)
    {
        $this->youtubeApiClient = $youtubeApiClient;
        $this->postFactory = $postFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $parameters = array())
    {
        $parameters = $this->resolveParameters($parameters);


        $response = $this->youtubeApiClient
            ->get('/playlistItems', array(
                'query' => array(
                    'playlistId' => $parameters['playlistId'],
                    'part' => 'snippet',
                    'pageToken' => $parameters['pageToken']
                ),
            ));

        $feed = new Feed();

        foreach ($response['items'] as $item) {
            $feed->addPost($this->postFactory->create($item));
        }

        return new ResultSet(
            $feed,
            $parameters,
            $this->getNextPaginationToken($response)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'youtube_playlist';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('playlistId');
        $resolver->setDefaults(array(
            'pageToken' => null,
        ));
    }

    protected function getNextPaginationToken($response)
    {
        if (!isset($response['nextPageToken'])) {
            return;
        }

        return new Token(array(
            'pageToken' => $response['nextPageToken'],
        ));
    }

}

