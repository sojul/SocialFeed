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
use Lns\SocialFeed\Model\Pagination\Token;
use Lns\SocialFeed\Model\ResultSet;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * FacebookPagePostsProvider.
 */
class FacebookPagePostsProvider extends AbstractProvider
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

        $response = $this->client->get('/'.$parameters['page_id'].'/posts', array(
            'query' => array(
                'fields' => $this->generateFieldsQueryString(array(
                    'actions',
                    'caption',
                    'created_time',
                    'id',
                    'likes',
                    'link',
                    'message',
                    'message_tags',
                    'full_picture',
                    'shares',
                    'type',
                    'from' => array(
                        'name',
                        'id',
                        'picture.type(large)',
                        'link',
                    ),
                )),
                'until' => $parameters['until'],
                'limit' => $parameters['limit'],
                '__paging_token' => $parameters['__paging_token'],
            ),
        ));

        $feed = $this->getFeed($response);

        return new ResultSet(
            $feed,
            $parameters,
            $this->getNextPaginationToken($response)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('page_id');

        $resolver->setDefaults(array(
            'until' => null,
            'limit' => null,
            '__paging_token' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'facebook_page';
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
        if (!isset($data['paging']['next'])) {
            return;
        }

        $parameters = $this->extractUrlParameters($data['paging']['next']);

        return new Token(array(
            'until' => $parameters['until'],
            'limit' => $parameters['limit'],
            '__paging_token' => $parameters['__paging_token'],
        ));
    }

    private function generateFieldsQueryString($fields)
    {
        $parts = array();

        foreach ($fields as $fieldKey => $fieldValue) {
            $parts[] = is_array($fieldValue) ? $fieldKey.'.fields('.$this->generateFieldsQueryString($fieldValue).')' : $fieldValue;
        }

        return implode($parts, ',');
    }
}
