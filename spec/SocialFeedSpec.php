<?php

namespace spec\Lns\SocialFeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Source\SourceInterface;

class SocialFeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\SocialFeed');
    }

    function it_shoud_be_possible_to_add_a_new_source(SourceInterface $source) {
        $this->addSource($source)->shouldReturn($this);
    }
}
