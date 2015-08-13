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
                'max_id' => $options['max_id'],
            ),
        ));

        $feed = new Feed();

        foreach ($result['statuses'] as $status) {
            $feed->addPost($this->postFactory->create($status));
        }

        $nextResultOptions = array();

        if (isset($result['search_metadata'])) {
            $parameters = $this->extractUrlParameters($result['search_metadata']['next_results']);

            $nextResultOptions = array(
                'max_id' => $parameters['max_id'],
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
            'max_id' => null,
        ));
    }
}
