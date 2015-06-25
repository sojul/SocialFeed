<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Facebook\FacebookSession;

class FacebookRequestFactorySpec extends ObjectBehavior
{
    function let(FacebookSession $session) {
        $this->beConstructedWith($session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\FacebookRequestFactory');
    }
}
