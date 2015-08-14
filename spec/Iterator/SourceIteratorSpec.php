<?php

namespace spec\Lns\SocialFeed\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\SourceInterface;
use Lns\SocialFeed\Model\ResultSetInterface;
use Lns\SocialFeed\Model\PostInterface;
use Lns\SocialFeed\Provider\ProviderInterface;

class SourceIteratorSpec extends ObjectBehavior
{
    protected $source;

    /**
     * let
     *
     * @param Lns\SocialFeed\SourceInterface $source
     */
    function let($source) {
        $this->source = $source;
        $this->beConstructedWith($this->source);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Iterator\SourceIterator');
    }

    function it_should_implement_iterator()
    {
        $this->shouldHaveType('\Iterator');
    }

    /**
     * it_should_iterate_over_source_result_sets
     *
     * @param Lns\SocialFeed\Provider\ProviderInterface $provider
     * @param Lns\SocialFeed\Model\ResultSetInterface $resultSet1
     * @param \Iterator $resultSet1Iterator
     * @param \Iterator $resultSet2Iterator
     * @param Lns\SocialFeed\Model\ResultSetInterface $resultSet2
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     * @param Lns\SocialFeed\Model\PostInterface $post3
     */
    function it_should_iterate_over_source_result_sets(
        $provider,
        $resultSet1,
        $resultSet1Iterator,
        $resultSet2Iterator,
        $resultSet2,
        $post1,
        $post2,
        $post3
    )
    {

        // first set contains $post1 and has a next set ($resultSet2)
        $resultSet1->hasNextResultSet()->willReturn(true);

        $resultSet1Iterator->valid()->willReturn(true);
        $resultSet1Iterator->current()->willReturn($post1);

        $resultSet1Iterator->next()->will(function () use ($resultSet1Iterator) {
            $resultSet1Iterator->valid()->willReturn(false);
            $resultSet1Iterator->current()->willReturn(null);
        });

        $resultSet1->getIterator()->willReturn($resultSet1Iterator);

        // second set contains $post2 and $post3
        $resultSet2Iterator->valid()->willReturn(true);
        $resultSet2Iterator->current()->willReturn($post2);
        $resultSet2Iterator->next()->will(function () use ($resultSet2Iterator, $post3) {
            $resultSet2Iterator->valid()->willReturn(true);
            $resultSet2Iterator->current()->willReturn($post3);
            $resultSet2Iterator->next()->will(function () use ($resultSet2Iterator) {
                $resultSet2Iterator->valid()->willReturn(false);
                $resultSet2Iterator->current()->willReturn(null);
            });
        });

        $resultSet2->hasNextResultSet()->willReturn(false);
        $resultSet2->getIterator()->willReturn($resultSet2Iterator);

        $provider->get(array(
            'foo' => 'bar'
        ))->willReturn($resultSet1);

        $provider->next($resultSet1)->willReturn($resultSet2);
        $provider->next($resultSet2)->willReturn(false);

        $this->source->getProvider()->willReturn($provider);
        $this->source->getOptions()->willReturn(array(
            'foo' => 'bar'
        ));

        $this->rewind();

        $this->current()->shouldReturn($post1);
        $this->valid()->shouldReturn(true);

        $this->next();

        $this->current()->shouldReturn($post2);
        $this->valid()->shouldReturn(true);

        $this->next();

        $this->current()->shouldReturn($post3);
        $this->valid()->shouldReturn(true);

        $this->next();

        $this->valid()->shouldReturn(false);
    }
}
