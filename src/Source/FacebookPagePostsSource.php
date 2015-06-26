<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Facebook\FacebookSession;
use Lns\SocialFeed\Client\FacebookOgClient;
use Lns\SocialFeed\Factory\FacebookPostFactory;

class FacebookPagePostsSource implements SourceInterface
{
    private $facebookSession;
    private $facebookOgClient;
    private $pageId;

    public function __construct(FacebookOgClient $facebookOgClient, FacebookPostFactory $facebookPostFactory, $pageId)
    {
        $this->facebookOgClient = $facebookOgClient;
        $this->facebookPostFactory = $facebookPostFactory;
        $this->pageId = $pageId;
    }

    public function getFeed() {

        $feed = new Feed();

        $objectList = $this
            ->facebookOgClient
            ->get('/' . $this->pageId . '/posts')
            ->getGraphObjectList();

        foreach($objectList as $object) {
            $feed->addPost($this->facebookPostFactory->createFromGraphObject($object));
        }

        return $feed;
    }
}
