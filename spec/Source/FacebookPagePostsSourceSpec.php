<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Facebook\FacebookResponse;
use Facebook\GraphObject;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

use Lns\SocialFeed\Client\FacebookOgClient;

class FacebookPagePostsSourceSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    function let(FacebookOgClient $client, PostFactoryInterface $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($this->client, $this->factory, 'page_id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\FacebookPagePostsSource');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_return_feed(FacebookResponse $response, GraphObject $object1, GraphObject $object2, PostInterface $post1, PostInterface $post2) {

        $objectList = [
            $object1,
            $object2
        ];

        $this->factory->createFacebookPostFromOpenGraphObject($object1)->willReturn($post1);
        $this->factory->createFacebookPostFromOpenGraphObject($object2)->willReturn($post2);

        $response->getGraphObjectList()->willReturn($objectList);

        $this->client->get('/page_id/posts')->willReturn($response);
        $this->getFeed('page_id')->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
