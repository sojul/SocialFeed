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

    /**
     * let
     *
     * @param Lns\SocialFeed\Client\ClientInterface $client
     * @param Lns\SocialFeed\Factory\PostFactoryInterface $factory
     */
    function let($client, $factory) {
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

    /**
     * it_should_return_feed
     *
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     */
    function it_should_return_feed($post1, $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get('/statuses/lookup.json', array(
            'query' => array(
              'id' => 'id1,id2',
            ),
          ))->willReturn([
            0 => $postData1,
            1 => $postData2
        ]);

        $this->factory->create($postData1)->willReturn($post1);
        $this->factory->create($postData2)->willReturn($post2);

        $this->get(array(
            'ids' => array('id1', 'id2')
        ))->shouldHaveType('Lns\SocialFeed\Model\ResultSet');
    }
}
