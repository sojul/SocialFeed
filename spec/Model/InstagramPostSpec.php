<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstagramPostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\InstagramPost');
        $this->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }
}
