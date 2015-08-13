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
 * TwitterStatusesLookupApiProvider.
 */
class TwitterStatusesLookupApiProvider extends AbstractProvider
{
    private $twitterApiClient;

    /**
     * __construct.
     *
     * @param ClientInterface      $twitterApiClient
     * @param PostFactoryInterface $postFactory
     */
    public function __construct(ClientInterface $twitterApiClient, PostFactoryInterface $postFactory)
    {
        $this->twitterApiClient = $twitterApiClient;
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

        $response = $this->twitterApiClient
            ->get('/1.1/statuses/lookup.json?id='.implode($options['ids'], ','));

        $result = $response;

        $feed = new Feed();

        foreach ($result as $status) {
            $feed->addPost($this->postFactory->create($status));
        }

        return new ResultSet($feed);
    }

    public function getName()
    {
        return 'twitter_status_lookup_api';
    }

    /**
     * configureOptionResolver.
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
        $resolver->setRequired('ids');
    }
}
