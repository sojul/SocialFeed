<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Facebook\FacebookSession;
use Lns\SocialFeed\Client\FacebookOgClient;
use Lns\SocialFeed\Adapter\GraphObjectToPostAdapter;

use Lns\SocialFeed\Factory\PostFactory;

class FacebookPagePostsSource implements SourceInterface
{
    private $facebookOgClient;
    private $pageId;
    private $postFactory;

    public function __construct(FacebookOgClient $facebookOgClient, PostFactory $postFactory, $pageId)
    {
        $this->facebookOgClient = $facebookOgClient;
        $this->postFactory = $postFactory;
        $this->pageId = $pageId;
    }

    public function getFeed() {

        $feed = new Feed();

        $objectList = $this
            ->facebookOgClient
            ->get('/' . $this->pageId . '/posts')
            ->getGraphObjectList();

        foreach($objectList as $object) {
            $feed->addPost($this->postFactory->createFromGraphObject($object));
        }

        return $feed;
    }
}
