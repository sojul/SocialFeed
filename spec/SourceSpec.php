<?php

namespace spec\Lns\SocialFeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Provider\ProviderInterface;

class SourceSpec extends ObjectBehavior
{
    function let(ProviderInterface $provider) {
        $this->beConstructedWith($provider, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source');
    }

    function it_should_implements_source_interface()
    {
        $this->shouldHaveType('Lns\SocialFeed\SourceInterface');
    }
}
