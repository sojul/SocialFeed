# SocialFeed

[![Build Status](https://travis-ci.org/LaNetscouade/SocialFeed.svg?branch=master)](https://travis-ci.org/LaNetscouade/SocialFeed)

## Installation

`composer require lns\social-feed`

## Usage

### Add Facebook Source

```php
use Lns\SocialFeed\SocialFeed;
use Lns\SocialFeed\Source\FacebookPagePostsSource;
use Lns\SocialFeed\Client\FacebookOgClient;
use Lns\SocialFeed\Client\FacebookRequestFactory;
use Lns\SocialFeed\Factory\FacebookPostFactory;
use Facebook\FacebookSession;

FacebookSession::setDefaultApplication('app-id', 'app-secret');

$session = FacebookSession::newAppSession();

$requestFactory = new FacebookRequestFactory($session);
$client = new FacebookOgClient($requestFactory);

$source = new FacebookPagePostsSource($client, new FacebookPostFactory(), 'page-id');
```

### Add Twitter Source

```php
use Lns\SocialFeed\SocialFeed;
use Lns\SocialFeed\Source\TwitterSearchApiSource;

$settings = array(
    'oauth_access_token' => "YOUR_OAUTH_ACCESS_TOKEN",
    'oauth_access_token_secret' => "YOUR_OAUTH_ACCESS_TOKEN_SECRET",
    'consumer_key' => "YOUR_CONSUMER_KEY",
    'consumer_secret' => "YOUR_CONSUMER_SECRET"
);

$twitterClient = new TwitterAPIExchange($settings);

$source = new TwitterSearchApiSource($twitterClient, 'search');
```

## Tests

`php bin/phpspec run`
