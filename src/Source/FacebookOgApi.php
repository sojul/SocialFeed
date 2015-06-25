<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Facebook\FacebookSession;
use Lns\SocialFeed\Client\FacebookOgClient;
use Lns\SocialFeed\Factory\FacebookPostFactory;

class FacebookOgApi implements SourceInterface
{
    private $facebookSession;

    private $facebookOgClient;

    public function __construct(FacebookOgClient $facebookOgClient, FacebookPostFactory $facebookPostFactory)
    {
        $this->facebookOgClient = $facebookOgClient;
        $this->facebookPostFactory = $facebookPostFactory;
    }

    public function getFeed($query) {

        $feed = new Feed();

        $objectList = $this
            ->facebookOgClient
            ->get('GET', $query)
            ->getGraphObjectList();

        foreach($objectList as $object) {
            $feed->addPost($this->facebookPostFactory->createFromGraphObject($object));
        }

        return $feed;
    }
}
