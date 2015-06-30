<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

use Lns\SocialFeed\Client\ClientInterface;

class FacebookPagePostsSourceSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(ClientInterface $client, PostFactoryInterface $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($this->client, $this->factory, 'page_id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\FacebookPagePostsSource');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_feed(PostInterface $post1, PostInterface $post2) {

        //$this->getFeed()->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
