<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config.php';

use Lns\SocialFeed\Client\FacebookApiClient;
use Lns\SocialFeed\Client\InstagramApiClient;
use Lns\SocialFeed\Client\InstagramTokenProvider;
use Lns\SocialFeed\Factory\FacebookPostFactory;
use Lns\SocialFeed\Factory\InstagramPostFactory;
use Lns\SocialFeed\Provider\FacebookPagePostsProvider;
use Lns\SocialFeed\Provider\InstagramUserMediaProvider;
use Lns\SocialFeed\SocialFeed;
use Lns\SocialFeed\Source;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\KeyValueStore\JsonFileStore;

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Silex\Application();

$app['debug'] = true;

$provider = new InstagramTokenProvider(
    $config['instagram']['clientId'],
    $config['instagram']['clientSecret'],
    $config['instagram']['redirectUri'],
    new JsonFileStore(__DIR__.'/instagram_token.json')
);

$app->get('/instagram/connect', function (Request $request) use ($provider, $app) {

    if ($request->query->has('code')) {
        $provider->setCode($request->query->get('code'));
        // Try to get an access token (using the authorization code grant)
        $token = $provider->getToken();

        return $app->redirect('/');
    }

    $authUrl = $provider->getAuthorizationUrl();

    return $app->redirect($authUrl);
});

$app->get('/', function (Request $request) use ($provider, $config) {

    try {
        $token = $provider->getToken();
    } catch (\Exception $e) {
        return 'You first need to get an access token <a href="/instagram/connect">/instagram/connect</a>';
    }

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getToken();

    $socialFeed = new SocialFeed();

    $instagramPostFactory = new InstagramPostFactory();
    $facebookPostFactory = new FacebookPostFactory();

    $instagramClient = new InstagramApiClient($token);

    $facebookClient = new FacebookApiClient(
        $config['facebook']['clientId'],
        $config['facebook']['clientSecret']
    );

    $socialFeed
        ->addSource(new Source(
            new InstagramUserMediaProvider($instagramClient, $instagramPostFactory),
            array('user_id' => 0000000000)
        ))
        ->addSource(new Source(
            new FacebookPagePostsProvider($facebookClient, $facebookPostFactory),
            array('page_id' => 00000000000)
        ));

    $output = '';

    foreach (new \LimitIterator($socialFeed, 0, 100) as $item) {
        $output .= $item->getCreatedAt()->format('d/m/Y').PHP_EOL;
        $output .= $item->getMessage().PHP_EOL.PHP_EOL;
    }

    return '<pre>'.$output.'</pre>';
});

$app->run();
