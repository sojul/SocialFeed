<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\Author');
    }
}
