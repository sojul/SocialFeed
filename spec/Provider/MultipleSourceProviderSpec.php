<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\SourceInterface;

class MultipleSourceProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\MultipleSourceProvider');
    }

    function it_should_implement_provider_interface()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\ProviderInterface');
    }

    function it_should_accept_new_source(SourceInterface $source) {
        $this->addSource($source)->shouldReturn($this);
    }

}
