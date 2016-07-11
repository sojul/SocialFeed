<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webmozart\KeyValueStore\Api\KeyValueStore;

class InstagramTokenProviderSpec extends ObjectBehavior
{
    function let(KeyValueStore $store) {
        $this->beConstructedWith('clientId', 'clientSecret', 'redirectUri', $store);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\InstagramTokenProvider');
    }
}
