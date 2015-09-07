# SocialFeed

[![Build Status](https://travis-ci.org/LaNetscouade/SocialFeed.svg?branch=master)](https://travis-ci.org/LaNetscouade/SocialFeed)

## Installation

`composer require lns\social-feed`

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Lns\SocialFeed\Provider\FacebookPagePostsProvider;
use Lns\SocialFeed\Provider\TwitterSearchApiProvider;
use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Client\FacebookApiClient;
use Lns\SocialFeed\Factory\FacebookPostFactory;
use Lns\SocialFeed\Factory\TweetFactory;
use Lns\SocialFeed\SocialFeed;
use Lns\SocialFeed\Source;

$socialFeed = new SocialFeed();
$facebookPostFactory = new FacebookPostFactory();
$tweetFactory = new TweetFactory();
$instagramPostFactory = new InstagramPostFactory();

$fbClient = new FacebookApiClient('681945715271604', 'e6f5472a5f159d8f235d9cfc14084b36');
$twitterClient = new TwitterApiClient('HqSutv9oOk64BqyAn474g', 'EdAzOS0RTuMnIQgQPPIM4gv66fwRlyzx2yfqjz9nHtA');

$socialFeed
    ->addSource(new Source(
        new FacebookPagePostsProvider($fbClient, $facebookPostFactory),
        ['page_id' => '110483805633200']
    ))
    ->addSource(new Source(
        new TwitterSearchApiProvider($twitterClient, $tweetFactory),
        ['query' => 'lanetscouade']
    ));

foreach(new \LimitIterator($socialFeed, 0, 10) as $item) {
    echo $item->getMessage() . PHP_EOL;
}

```

## Tests

`php bin/phpspec run`
