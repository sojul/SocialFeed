<?php

namespace spec\Lns\SocialFeed\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webmozart\KeyValueStore\Api\KeyValueStore;

class WebmozartKeyValueStoreAdapterSpec extends ObjectBehavior
{
    function let(KeyValueStore $keyValueStore) {
        $this->beConstructedWith($keyValueStore);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Store\WebmozartKeyValueStoreAdapter');
    }

    function it_should_implements_store_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Store\StoreInterface');
    }
}
