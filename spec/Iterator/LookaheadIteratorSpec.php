<?php

namespace spec\Lns\SocialFeed\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LookaheadIteratorSpec extends ObjectBehavior
{
    function let(\Iterator $iterator) {
        $this->beConstructedWith($iterator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Iterator\LookaheadIterator');
    }
}
