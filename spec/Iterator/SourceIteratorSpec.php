<?php

namespace spec\Lns\SocialFeed\Iterator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Lns\SocialFeed\SourceInterface;
use Lns\SocialFeed\Model\ResultSetInterface;
use Lns\SocialFeed\Provider\ProviderInterface;

class SourceIteratorSpec extends ObjectBehavior
{
    protected $source;

    function let(SourceInterface $source) {
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

    function it_should_iterate_over_source_result_sets(
        ProviderInterface $provider,
        ResultSetInterface $resultSet1,
        ResultSetInterface $resultSet2
    )
    {
        $resultSet1->hasNextResult()->willReturn(true);
        $resultSet1->getNextResultOptions()->willReturn(array('page' => 2));
        $resultSet2->hasNextResult()->willReturn(false);
        $resultSet2->getNextResultOptions()->willReturn(array('page' => 3));

        $provider->getResult(array(
            'foo' => 'bar'
        ))->willReturn($resultSet1);

        $provider->getResult(array(
            'foo' => 'bar',
            'page' => 2
        ))->willReturn($resultSet2);

        $this->source->getProvider()->willReturn($provider);
        $this->source->getOptions()->willReturn(array(
            'foo' => 'bar'
        ));

        $this->current()->shouldReturn($resultSet1);
        $this->valid()->shouldReturn(true);

        $this->next();

        $this->current()->shouldReturn($resultSet2);
        $this->valid()->shouldReturn(true);

        $this->next();

        $this->valid()->shouldReturn(false);
    }
}
