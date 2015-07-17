<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

class TwitterStatusesLookupApiProviderSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(ClientInterface $client, PostFactoryInterface $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($client, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\TwitterStatusesLookupApiProvider');
    }

    function it_should_implement_provider_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Provider\ProviderInterface');
    }

    function it_should_return_feed(PostInterface $post1, PostInterface $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get('/1.1/statuses/lookup.json?id=id1,id2')->willReturn([
            0 => $postData1,
            1 => $postData2
        ]);

        $this->factory->createTweetFromApiData($postData1)->willReturn($post1);
        $this->factory->createTweetFromApiData($postData2)->willReturn($post2);

        $this->getResult(array(
            'ids' => array('id1', 'id2')
        ))->shouldHaveType('Lns\SocialFeed\Model\ResultSet');
    }
}
