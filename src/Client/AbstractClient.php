<?php

namespace Lns\SocialFeed\Client;

abstract class AbstractClient implements ClientInterface {

    protected function applyDefaultClientQuery($client, $options) {
        if (!isset($options['query'])) {
            $options['query'] = array();
        }

        $options['query'] = array_merge($options['query'], $client->getConfig('query'));

        return $options;
    }
}
