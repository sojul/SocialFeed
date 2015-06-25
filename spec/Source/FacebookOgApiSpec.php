<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookOgApiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\FacebookOgApi');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }
}
