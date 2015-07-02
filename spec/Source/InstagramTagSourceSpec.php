<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

class InstagramTagSourceSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(ClientInterface $client, PostFactoryInterface $factory) {
        $this->factory = $factory;
        $this->client = $client;
        $this->beConstructedWith($client, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\InstagramTagSource');
    }

    function it_should_implement_source_interface() {
        $this->shouldHaveType('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_feed(PostInterface $post1, PostInterface $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get(Argument::any())->willReturn([
            'data' => array(
                0 => $postData1,
                1 => $postData2
            )
        ]);

        $this->factory->createInstagramPostFromApiData($postData1)->willReturn($post1);
        $this->factory->createInstagramPostFromApiData($postData2)->willReturn($post2);

        $this->getFeed(array(
            'tag_name' => 'foo'
        ))->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
