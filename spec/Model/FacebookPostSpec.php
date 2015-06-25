<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookPostSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\FacebookPost');
        $this->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }
}
