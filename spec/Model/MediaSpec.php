<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MediaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\Media');
    }

    function it_should_implement_media_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Model\MediaInterface');
    }
}
