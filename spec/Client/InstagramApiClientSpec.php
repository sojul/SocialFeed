<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstagramApiClientSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith('client_id', 'client_secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\InstagramApiClient');
    }
}
