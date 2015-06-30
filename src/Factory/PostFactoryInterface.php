<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;

interface PostFactoryInterface
{
    public function createFacebookPostFromApiData(array $data);
    public function createTweetFromApiData(array $data);
    public function createInstagramPostFromApiData(array $data);
}
