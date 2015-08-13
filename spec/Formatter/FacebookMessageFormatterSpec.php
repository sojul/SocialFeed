<?php

namespace spec\Lns\SocialFeed\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\Model\ReferenceInterface;
use Lns\SocialFeed\Model\ReferenceType;

class FacebookMessageFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Formatter\FacebookMessageFormatter');
    }

    function it_should_implement_message_formatter_interface() {
        $this->shouldImplement('Lns\SocialFeed\Formatter\MessageFormatterInterface');
    }

    /**
     * it_should_replace_input_message_references_by_reference_html_link
     *
     * @param Lns\SocialFeed\Model\ReferenceInterface $reference1
     * @param Lns\SocialFeed\Model\ReferenceInterface $reference2
     */
    function it_should_replace_input_message_references_by_reference_html_link($reference1, $reference2) {
        $reference1->getStartIndice()->willReturn(5);
        $reference1->getEndIndice()->willReturn(10);
        $reference1->getType()->willReturn(ReferenceType::USER);
        $reference1->getData()->willReturn(array(
            "id"          => 6844292,
            "name"        => "John Doe",
            "type"        => "user",
            "offset"      => 5,
            "length"      => 5
        ));

        $reference2->getStartIndice()->willReturn(12);
        $reference2->getEndIndice()->willReturn(17);
        $reference2->getType()->willReturn(ReferenceType::PAGE);
        $reference2->getData()->willReturn(array(
            "id"          => 32425,
            "name"        => "test",
            "type"        => "page",
            "offset"      => 5,
            "length"      => 5
        ));

        $this->format('test @jdoe, @test bar', [$reference2, $reference1])
            ->shouldReturn('test <a href="https://www.facebook.com/6844292" target="_blank">@jdoe</a>, <a href="https://www.facebook.com/32425" target="_blank">@test</a> bar');

        $this->format('foo #média bar', [])
            ->shouldReturn('foo <a href="https://www.facebook.com/hashtag/média" target="_blank">#média</a> bar');

        $this->format('foo http://test.com bar', [])
            ->shouldReturn('foo <a href="http://test.com" target="_blank">http://test.com</a> bar');
    }
}
