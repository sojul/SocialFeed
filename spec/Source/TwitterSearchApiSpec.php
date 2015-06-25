<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TwitterSearchApiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\TwitterSearchApi');
        $this->shouldImplement('Lns\SocialFeed\Source\SourceInterface');
    }
}
