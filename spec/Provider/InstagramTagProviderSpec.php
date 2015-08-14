<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

class InstagramTagProviderSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    /**
     * let
     *
     * @param Lns\SocialFeed\Client\ClientInterface $client
     * @param Lns\SocialFeed\Factory\PostFactoryInterface $factory
     */
    function let($client, $factory) {
        $this->factory = $factory;
        $this->client = $client;
        $this->beConstructedWith($client, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\InstagramTagProvider');
    }

    function it_should_implement_provider_interface() {
        $this->shouldHaveType('Lns\SocialFeed\Provider\ProviderInterface');
    }

    /**
     * it_should_return_feed
     *
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     */
    function it_should_return_feed($post1, $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get(Argument::any(), Argument::any())->willReturn([
            'data' => array(
                0 => $postData1,
                1 => $postData2
            ),
            'pagination' => array(
                "next_max_tag_id" => "1234617838724914488",
                "deprecation_warning" => "next_max_id and min_id are deprecated for this endpoint; use min_tag_id and max_tag_id instead",
                "next_max_id" => "1234617838724914488",
                "next_min_id" => "1234617838724914489",
                "min_tag_id" => "1234617838724914489",
                "next_url" => "https://api.instagram.com/v1/tags/foo/media/recent?access_token=228862345.1feb32f.376d2710304c4b688518aab329085ebe&max_tag_id=1234617838724914488"
            )
        ]);

        $this->factory->create($postData1)->willReturn($post1);
        $this->factory->create($postData2)->willReturn($post2);

        $this->get(array(
            'tag_name' => 'foo'
        ))->shouldHaveType('Lns\SocialFeed\Model\ResultSet');
    }
}
