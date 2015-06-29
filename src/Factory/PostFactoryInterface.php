<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;

interface PostFactoryInterface
{
    public function createFacebookPostFromOpenGraphObject(GraphObject $graphObject);
    public function createTweetFromApiData(array $data);
    public function createInstagramPostFromApiData(array $data);
}
