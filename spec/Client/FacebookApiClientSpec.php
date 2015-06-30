<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookApiClientSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith('client_key', 'client_secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\FacebookApiClient');
    }
}
