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

    function it_should_iterate_over_source_posts(
        SourceIterator $sourceIterator1,
        SourceIterator $sourceIterator2,
        SourceIterator $sourceIterator3,
        PostInterface $post1,
        PostInterface $post2,
        PostInterface $post3,
        PostInterface $post4,
        PostInterface $post5,
        PostInterface $post6
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
        $this->next();
        $this->current()->shouldReturn($post5);
        $this->next();
        $this->current()->shouldReturn($post4);
        $this->next();
        $this->current()->shouldReturn($post3);
        $this->next();
        $this->current()->shouldReturn($post2);
        $this->next();
        $this->current()->shouldReturn($post1);
    }

    private function prepareSourceIteratorDouble(SourceIterator $sourceIterator, \Iterator $posts) {
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


