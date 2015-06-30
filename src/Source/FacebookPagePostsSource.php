<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Facebook\FacebookSession;
use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Adapter\GraphObjectToPostAdapter;

use Lns\SocialFeed\Factory\PostFactoryInterface;

class FacebookPagePostsSource implements SourceInterface
{
    private $client;
    private $pageId;
    private $postFactory;

    public function __construct(ClientInterface $client, PostFactoryInterface $postFactory, $pageId)
    {
        $this->client = $client;
        $this->postFactory = $postFactory;
        $this->pageId = $pageId;
    }

    public function getFeed() {

        $fieldsString = $this->generateFieldsQueryString(array(
            'actions',
            'caption',
            'created_time',
            'id',
            'likes',
            'message',
            'message_tags',
            'picture',
            'shares',
            'type',
            'from' => array(
                'name',
                'id',
                'picture'
            )
        ));

        $feed = new Feed();

        $data = $this
            ->client
            ->get('/' . $this->pageId . '/posts?fields=' . $fieldsString);

        foreach($data['data'] as $postData) {
            $feed->addPost($this->postFactory->createFacebookPostFromApiData($postData));
        }

        return $feed;
    }

    private function generateFieldsQueryString($fields) {
        $parts = array();

        foreach($fields as $fieldKey => $fieldValue) {
            $parts[] = is_array($fieldValue) ? $fieldKey . '.fields(' . $this->generateFieldsQueryString($fieldValue) . ')' : $fieldValue;
        }

        return join($parts, ',');
    }
}
