<?php

namespace spec\Lns\SocialFeed\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Model\PostInterface;
use Lns\SocialFeed\Model\FeedInterface;
use Lns\SocialFeed\Model\Feed;

class FeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Model\Feed');
    }

    function it_is_iterable() {
        $this->shouldImplement('\IteratorAggregate');
    }

    function it_implement_feed_interface() {
        $this->shouldImplement('Lns\SocialFeed\Model\FeedInterface');
    }

    function it_can_be_sortable() {
        $this->sort()->shouldReturn($this);
    }

    /**
     * it_should_be_possible_to_add_a_post_to_feed
     *
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     */
    function it_should_be_possible_to_add_a_post_to_feed($post1, $post2)
    {
        $post1->getUniqueIdentifier()->willReturn('id1');
        $post2->getUniqueIdentifier()->willReturn('id2');

        $this->addPost($post1)->shouldReturn($this);
        $this->addPost($post2)->shouldReturn($this);

        $this->getPost('id1')->shouldReturn($post1);
        $this->getPost('id2')->shouldReturn($post2);

        $iterator = $this->getIterator();
    }

    /**
     * it_can_merge_with_another_feed
     *
     * @param Lns\SocialFeed\Model\FeedInterface $otherFeed
     */
    function it_can_merge_with_another_feed($otherFeed) {

        $this->merge($otherFeed)->shouldHaveType('Lns\SocialFeed\Model\FeedInterface');
    }
}
