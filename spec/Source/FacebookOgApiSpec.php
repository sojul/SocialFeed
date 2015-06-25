<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Facebook\FacebookResponse;
use Facebook\GraphObject;
use Lns\SocialFeed\Model\Feed;

use Lns\SocialFeed\Client\FacebookOgClient;

class FacebookOgApiSpec extends ObjectBehavior
{
    protected $client;

    function let(FacebookOgClient $client) {
        $this->client = $client;
        $this->beConstructedWith($this->client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\FacebookOgApi');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_feed(FacebookResponse $response, GraphObject $object1, GraphObject $object2) {

        $objectList = [
            $object1,
            $object2
        ];

        $response->getGraphObjectList()->willReturn($objectList);

        $this->client->get('GET', 'foo')->willReturn($response);
        $this->getFeed('foo')->shouldReturn($objectList);

        //->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
