<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Factory\PostFactory;

class TwitterSearchApiSourceSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(TwitterApiClient $client, PostFactory $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($client, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\TwitterSearchApiSource');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_feed(PostInterface $post1, PostInterface $post2) {
    }
}
