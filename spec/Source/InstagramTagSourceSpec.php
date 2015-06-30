<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;

class InstagramTagSourceSpec extends ObjectBehavior
{
    function let(ClientInterface $client, PostFactoryInterface $postFactory) {
        $this->beConstructedWith($client, $postFactory, 'tagname');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\InstagramTagSource');
    }

    function it_should_implement_source_interface() {
        $this->shouldHaveType('Lns\SocialFeed\Source\SourceInterface');
    }

}
