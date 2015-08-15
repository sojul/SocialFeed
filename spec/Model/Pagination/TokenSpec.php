<?php

namespace spec\Lns\SocialFeed\Model\Pagination;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\Pagination\Token');
    }
}
