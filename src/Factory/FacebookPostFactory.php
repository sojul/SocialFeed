<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;

class FacebookPostFactory
{
    public function createFromGraphObject(GraphObject $graphObject)
    {
        $facebookPost = new FacebookPost();

        return $facebookPost;
    }
}
