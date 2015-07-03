<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Provider\ProviderInterface;
use Lns\SocialFeed\Model\FeedInterface;

class ProviderChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\ProviderChain');
    }

    function it_should_implement_provider_interface()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\ProviderInterface');
    }

    function it_should_accept_a_new_provider(ProviderInterface $provider) {
        $this->addProvider('provider1', $provider)->shouldReturn($this);
    }

    function it_should_return_feed(ProviderInterface $provider1, FeedInterface $feed1, ProviderInterface $provider2, FeedInterface $feed2) {
        $provider1Options = ['option1' => 'value1'];
        $provider2Options = ['option2' => 'value2'];

        $provider1->getFeed($provider1Options)->willReturn($feed1);
        $provider2->getFeed($provider2Options)->willReturn($feed2);

        $this->addProvider('provider1', $provider1);
        $this->addProvider('provider2', $provider2);

        $this->getFeed(array(
            'provider1' => $provider1Options,
            'provider2' => $provider2Options
        ))->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
