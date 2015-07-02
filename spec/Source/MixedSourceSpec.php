<?php

namespace spec\Lns\SocialFeed\Source;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Source\SourceInterface;
use Lns\SocialFeed\Model\FeedInterface;

class MixedSourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\MixedSource');
    }

    function it_should_implement_source_interface()
    {
        $this->shouldHaveType('Lns\SocialFeed\Source\SourceInterface');
    }

    function it_should_accept_a_new_source(SourceInterface $source) {
        $this->addSource('source1', $source)->shouldReturn($this);
    }

    function it_should_return_feed(SourceInterface $source1, FeedInterface $feed1, SourceInterface $source2, FeedInterface $feed2) {
        $source1Options = ['option1' => 'value1'];
        $source2Options = ['option2' => 'value2'];

        $source1->getFeed($source1Options)->willReturn($feed1);
        $source2->getFeed($source2Options)->willReturn($feed2);

        $this->addSource('source1', $source1);
        $this->addSource('source2', $source2);

        $this->getFeed(array(
            'source1' => ['option1' => 'value1'],
            'source2' => ['option2' => 'value2']
        ))->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }
}
