<?php

namespace spec\Lns\SocialFeed\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResultSetIteratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Iterator\ResultSetIterator');
    }
}
