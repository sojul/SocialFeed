<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReferenceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\Reference');
    }

    function it_should_implement_reference_interface() {
        $this->shouldImplement('Lns\SocialFeed\Model\ReferenceInterface');
    }
}
