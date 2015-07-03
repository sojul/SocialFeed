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
use Lns\SocialFeed\Provider\ProviderChain;
use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Client\FacebookApiClient;
use Lns\SocialFeed\Client\FacebookRequestFactory;
use Lns\SocialFeed\Factory\PostFactory;

$providerChain = new ProviderChain();
$postFactory = new PostFactory();

$client = new FacebookApiClient('681945715271604', 'e6f5472a5f159d8f235d9cfc14084b36');

$providerChain->addProvider('fb', new FacebookPagePostsProvider($client, $postFactory));

// add twitter provider
$twitterClient = new TwitterApiClient('HqSutv9oOk64BqyAn474g', 'EdAzOS0RTuMnIQgQPPIM4gv66fwRlyzx2yfqjz9nHtA');

$providerChain->addProvider('tw', new TwitterSearchApiProvider($twitterClient, $postFactory));

$feed = $providerChain->getFeed([
    'fb' => ['page_id' => '110483805633200'],
    'tw' => ['query' => 'lanetscouade'],
]);

foreach($feed as $item) {
    echo $item->getMessage() . PHP_EOL;
}

```

## Tests

`php bin/phpspec run`
