<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;
use Lns\SocialFeed\Exception\UndefinedOptionsException;

use Lns\SocialFeed\Client\ClientInterface;

class FacebookPagePostsSourceSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(ClientInterface $client, PostFactoryInterface $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($this->client, $this->factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\FacebookPagePostsSource');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_an_exection_if_page_id_option_is_not_set() {
        $this->shouldThrow('Lns\SocialFeed\Exception\MissingOptionsException')->duringGetFeed();
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

        $this->factory->createFacebookPostFromApiData($postData1)->willReturn($post1);
        $this->factory->createFacebookPostFromApiData($postData2)->willReturn($post2);

        $this->getFeed(array(
            'page_id' => '12334533434'
        ))->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
