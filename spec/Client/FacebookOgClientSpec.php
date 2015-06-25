<?php

namespace spec\Lns\SocialFeed\Client;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Client\FacebookRequestFactory;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphObject;

class FacebookOgClientSpec extends ObjectBehavior
{
    function let(FacebookRequestFactory $requestFactory, FacebookRequest $request, FacebookResponse $response, GraphObject $graphObject) {
        $request->execute()->willReturn($response);
        $requestFactory->create(Argument::any(), Argument::any())->willReturn($request);
        $this->beConstructedWith($requestFactory);
    }

    function it_should_make_get_request() {
        $this->get('/foo')->shouldHaveType('Facebook\FacebookResponse');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Client\FacebookOgClient');
    }
}
