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
     * getResult.
     *
     * @param array $options
     */
    public function getResult(array $options = array())
    {
        $options = $this->resolveOptions($options);

        $fieldsString = $this->generateFieldsQueryString(array(
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
        ));

        $feed = new Feed();

        $data = $this->client->get('/'.$options['page_id'].'/posts', array(
            'query' => array(
                'fields' => $fieldsString,
                'until' => $options['until'],
                'limit' => $options['limit'],
                '__paging_token' => $options['__paging_token'],
            ),
        ));

        foreach ($data['data'] as $postData) {
            $feed->addPost($this->postFactory->create($postData));
        }

        $nextResultOptions = array();

        // extract pagination parameters
        if (isset($data['paging']['next'])) {
            $parameters = $this->extractUrlParameters($data['paging']['next']);
            $nextResultOptions = array(
                'until' => $parameters['until'],
                'limit' => $parameters['limit'],
                '__paging_token' => $parameters['__paging_token'],
            );
        }

        return new ResultSet($feed, $nextResultOptions);
    }

    public function getName()
    {
        return 'facebook_page';
    }

    /**
     * configureOptionResolver.
     *
     * @param OptionsResolver $resolver
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
     * generateFieldsQueryString.
     *
     * @param $fields
     */
    private function generateFieldsQueryString($fields)
    {
        $parts = array();

        foreach ($fields as $fieldKey => $fieldValue) {
            $parts[] = is_array($fieldValue) ? $fieldKey.'.fields('.$this->generateFieldsQueryString($fieldValue).')' : $fieldValue;
        }

        return implode($parts, ',');
    }
}
