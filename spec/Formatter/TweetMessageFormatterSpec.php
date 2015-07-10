<?php

namespace spec\Lns\SocialFeed\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Model\ReferenceInterface;
use Lns\SocialFeed\Model\ReferenceType;

class TweetMessageFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Formatter\TweetMessageFormatter');
    }

    function it_should_implement_message_formatter_interface() {
        $this->shouldImplement('Lns\SocialFeed\Formatter\MessageFormatterInterface');
    }

    function it_should_replace_input_message_references_by_reference_html_link(ReferenceInterface $reference1, ReferenceInterface $reference2) {
        $reference1->getStartIndice()->willReturn(5);
        $reference1->getEndIndice()->willReturn(10);
        $reference1->getType()->willReturn(ReferenceType::USER);
        $reference1->getData()->willReturn(array(
            "screen_name" => "jdoe",
            "name"        => "John Doe",
            "id"          => 6844292,
            "id_str"      => "6844292",
            "indices"     => [5, 10]
        ));

        $reference2->getStartIndice()->willReturn(12);
        $reference2->getEndIndice()->willReturn(17);
        $reference2->getType()->willReturn(ReferenceType::HASHTAG);
        $reference2->getData()->willReturn(array(
            "text"    => "test",
            "indices" => [12, 17]
        ));

        $this->format('test @jdoe, #test bar', [$reference1, $reference2])
            ->shouldReturn('test <a href="https://twitter.com/jdoe" target="_blank">@jdoe</a>, <a href="https://twitter.com/hashtag/test" target="_blank">#test</a> bar');
    }
}
