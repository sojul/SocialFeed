<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;

class TwitterSearchStorageProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\TwitterSearchStorageProvider');
    }
}
