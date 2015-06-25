<?php

namespace spec\Lns\SocialFeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SocialFeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\SocialFeed');
    }
}
