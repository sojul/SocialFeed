<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Client;

abstract class AbstractClient implements ClientInterface
{
    protected function applyDefaultClientQuery($client, $options)
    {
        if (!isset($options['query'])) {
            $options['query'] = array();
        }

        $options['query'] = array_merge($options['query'], $client->getConfig('query'));

        return $options;
    }
}
