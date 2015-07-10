<?php

namespace spec\Lns\SocialFeed\Formatter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstagramMessageFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Formatter\InstagramMessageFormatter');
    }

    function it_should_implement_message_formatter_interface() {
        $this->shouldImplement('Lns\SocialFeed\Formatter\MessageFormatterInterface');
    }

    function it_should_replace_input_message_references_by_reference_html_link() {
        $this->format('foo #média bar', [])
            ->shouldReturn('foo <a href="https://instagram.com/explore/tags/média" target="_blank">#média</a> bar');

        $this->format('foo @user1é bar', [])
            ->shouldReturn('foo <a href="https://instagram.com/user1é/" target="_blank">@user1é</a> bar');
    }
}
