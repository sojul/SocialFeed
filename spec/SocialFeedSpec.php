<?php

namespace spec\Lns\SocialFeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Provider\ProviderInterface;

class SocialFeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\SocialFeed');
    }

    function it_shoud_be_possible_to_add_a_new_provider(ProviderInterface $provider) {
        $this->addProvider($provider)->shouldReturn($this);
    }
}
