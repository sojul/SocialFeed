<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Facebook\GraphObject;

class FacebookPostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\FacebookPostFactory');
    }

    function it_should_create_facebook_post_from_graph_object(GraphObject $objectGraph, GraphObject $fromObjectGraph)
    {
        $fromObjectGraph->getProperty('name')->willReturn('John Doe');
        $fromObjectGraph->getProperty('id')->willReturn('user_id_1');

        $objectGraph->getProperty('message')->willReturn('Message text');
        $objectGraph->getProperty('id')->willReturn('message_id_1');
        $objectGraph->getProperty('from')->willReturn($fromObjectGraph);

        $this->createFromGraphObject($objectGraph)->shouldHaveType('Lns\SocialFeed\Model\FacebookPost');
    }
}
