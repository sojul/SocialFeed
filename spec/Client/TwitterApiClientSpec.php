<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TwitterApiClientSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith('consumer_key', 'consumer_secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\TwitterApiClient');
    }
}
