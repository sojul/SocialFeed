<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Client\InstagramApiClient;
use Lns\SocialFeed\Factory\PostFactory;

class InstagramTagSourceSpec extends ObjectBehavior
{
    function let(InstagramApiClient $client, PostFactory $postFactory) {
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
