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

    function it_should_create_facebook_post_from_graph_object(GraphObject $objectGraph)
    {
        $this->createFromGraphObject($objectGraph)->shouldHaveType('Lns\SocialFeed\Model\FacebookPost');
    }
}
