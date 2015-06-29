# SocialFeed

[![Build Status](https://travis-ci.org/LaNetscouade/SocialFeed.svg?branch=master)](https://travis-ci.org/LaNetscouade/SocialFeed)

## Installation

`composer require lns\social-feed`

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Lns\SocialFeed\Source\FacebookPagePostsSource;
use Lns\SocialFeed\Source\TwitterSearchApiSource;
use Lns\SocialFeed\Source\MixedSource;
use Lns\SocialFeed\Client\TwitterApiClient;
use Lns\SocialFeed\Client\FacebookOgClient;
use Lns\SocialFeed\Client\FacebookRequestFactory;
use Lns\SocialFeed\Factory\PostFactory;
use Facebook\FacebookSession;

FacebookSession::setDefaultApplication('app_id', 'app_secret');

$mixedSource = new MixedSource();
$postFactory = new PostFactory();

// add Facebook source
$session = FacebookSession::newAppSession();

$requestFactory = new FacebookRequestFactory($session);
$client = new FacebookOgClient($requestFactory);

$mixedSource->addSource(new FacebookPagePostsSource($client, $postFactory, 'page_id'));

// add twitter source
$twitterClient = new TwitterApiClient('app_id', 'app_secret');

$mixedSource->addSource(new TwitterSearchApiSource($twitterClient, $postFactory, 'lanetscouade'));

$feed = $mixedSource->getFeed()->sort();

```

## Tests

`php bin/phpspec run`
