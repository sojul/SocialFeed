<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;
use Lns\SocialFeed\Exception\UndefinedOptionsException;

use Lns\SocialFeed\Client\ClientInterface;

class FacebookPagePostsProviderSpec extends ObjectBehavior
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
        $this->shouldHaveType('Lns\SocialFeed\Provider\FacebookPagePostsProvider');
        $this->shouldImplement('Lns\SocialFeed\Provider\ProviderInterface');
    }

    function it_should_return_an_exection_if_page_id_option_is_not_set() {
        $this->shouldThrow('Lns\SocialFeed\Exception\MissingOptionsException')->duringGetResult();
    }

    function it_should_return_feed(PostInterface $post1, PostInterface $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get(Argument::any(), Argument::any())->willReturn([
            'data' => array(
                0 => $postData1,
                1 => $postData2
            ),
            'paging' => array(
                "previous" => "https://graph.facebook.com/page_id/posts?since=1433776347&limit=25&__paging_token=enc_AdBJBmZACKRKhWZCfUEwnRGw8jGfFZCGl2EiYxebr461J81BIsIRwu69lD0DmRZCix9Pj5ULR0SdfOu16UkN5ZAQB9xJl&__previous=1",
                "next" => "https://graph.facebook.com/page_id/posts?since=1433776347&limit=25&__paging_token=enc_AdBJBmZACKRKhWZCfUEwnRGw8jGfFZCGl2EiYxebr461J81BIsIRwu69lD0DmRZCix9Pj5ULR0SdfOu16UkN5ZAQB9xJl"
            )
        ]);

        $this->factory->create($postData1)->willReturn($post1);
        $this->factory->create($postData2)->willReturn($post2);

        $this->getResult(array(
            'page_id' => '12334533434'
        ))->shouldHaveType('Lns\SocialFeed\Model\ResultSet');
    }
}
