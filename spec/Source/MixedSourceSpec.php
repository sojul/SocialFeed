<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Source\SourceInterface;

class MixedSourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\MixedSource');
    }

    function it_should_implement_source_interface()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_accept_a_new_source(SourceInterface $source) {
        $this->addSource($source)->shouldReturn($this);
    }
}
