<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Facebook\GraphObject;

class PostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\PostFactory');
    }

    function it_should_create_facebook_post_from_graph_object(GraphObject $graphObject, GraphObject $author) {
        $author->getProperty('id')->willReturn('user_1_id');
        $author->getProperty('name')->willReturn('John doe');

        $graphObject->getProperty('id')->willReturn('post_1');
        $graphObject->getProperty('message')->willReturn('Lorem ipsum');
        $graphObject->getProperty('from')->willReturn($author);

        $this->createFromGraphObject($graphObject)->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }

    function it_should_create_twitter_tweet_from_twitter_api_data() {
        $data = [
            'text' => 'Lorem ipsum',
            'id' => '23249134'
        ];

        $this->createFromTwitterApiData($data)->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }
}
