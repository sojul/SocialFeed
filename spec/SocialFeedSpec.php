<?php

namespace spec\Lns\SocialFeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\SourceInterface;
use Lns\SocialFeed\Model\PostInterface;
use Lns\SocialFeed\Iterator\SourceIterator;

class SocialFeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\SocialFeed');
    }

    function it_should_implements_iterator_interface()
    {
        $this->shouldImplement('\Iterator');
    }

    /**
     * it_should_iterate_over_source_posts
     *
     * @param Lns\SocialFeed\Iterator\SourceIterator $sourceIterator1
     * @param Lns\SocialFeed\Iterator\SourceIterator $sourceIterator2
     * @param Lns\SocialFeed\Iterator\SourceIterator $sourceIterator3
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     * @param Lns\SocialFeed\Model\PostInterface $post3
     * @param Lns\SocialFeed\Model\PostInterface $post4
     * @param Lns\SocialFeed\Model\PostInterface $post5
     * @param Lns\SocialFeed\Model\PostInterface $post6
     */
    function it_should_iterate_over_source_posts(
        $sourceIterator1,
        $sourceIterator2,
        $sourceIterator3,
        $post1,
        $post2,
        $post3,
        $post4,
        $post5,
        $post6
    ) {

        $post1->getCreatedAt()->willReturn(new \DateTime('2015-01-01'));
        $post2->getCreatedAt()->willReturn(new \DateTime('2015-02-01'));
        $post3->getCreatedAt()->willReturn(new \DateTime('2015-03-01'));
        $post4->getCreatedAt()->willReturn(new \DateTime('2015-04-01'));
        $post5->getCreatedAt()->willReturn(new \DateTime('2015-05-01'));
        $post6->getCreatedAt()->willReturn(new \DateTime('2015-06-01'));

        $sourceIterator1 = $this->prepareSourceIteratorDouble($sourceIterator1, new \ArrayIterator([$post6, $post3]));
        $sourceIterator2 = $this->prepareSourceIteratorDouble($sourceIterator2, new \ArrayIterator([$post5, $post4]));
        $sourceIterator3 = $this->prepareSourceIteratorDouble($sourceIterator3, new \ArrayIterator([$post2, $post1]));

        $this->addSourceIterator($sourceIterator1)->shouldReturn($this);
        $this->addSourceIterator($sourceIterator2)->shouldReturn($this);
        $this->addSourceIterator($sourceIterator3)->shouldReturn($this);

        $this->rewind();

        $this->current()->shouldReturn($post6);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->current()->shouldReturn($post5);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->current()->shouldReturn($post4);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->current()->shouldReturn($post3);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->current()->shouldReturn($post2);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->current()->shouldReturn($post1);
        $this->valid()->shouldReturn(true);
        $this->next();
        $this->valid()->shouldReturn(false);
    }

    /**
     * prepareSourceIteratorDouble
     *
     * @param Lns\SocialFeed\Iterator\SourceIterator $sourceIterator
     * @param \Iterator $posts
     */
    private function prepareSourceIteratorDouble($sourceIterator, $posts) {
        $sourceIterator->rewind()->will(function() use($sourceIterator, $posts) {
            $posts->rewind();
            $sourceIterator->current()->will(function() use($posts) {
                return $posts->current();
            });
            $sourceIterator->next()->will(function() use($posts) {
                return $posts->next();
            });
            $sourceIterator->valid()->will(function() use($posts) {
                return $posts->valid();
            });
            $sourceIterator->key()->will(function() use($posts) {
                return $posts->key();
            });
        });

        return $sourceIterator;
    }
}


