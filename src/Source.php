<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed;

use Lns\SocialFeed\Provider\ProviderInterface;

class Source implements SourceInterface
{
    private $provider;
    private $options;

    public function __construct(ProviderInterface $provider, array $options = array())
    {
        $this->provider = $provider;
        $this->options = $options;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
