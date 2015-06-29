<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;
use Lns\SocialFeed\Model\InstagramPost;
use Lns\SocialFeed\Model\Author;
use Lns\SocialFeed\Model\Tweet;

class PostFactory
{
    public function createFromGraphObject(GraphObject $graphObject)
    {
        $from = $graphObject->getProperty('from');

        $author = new Author();
        $author->setIdentifier($from->getProperty('id'));
        $author->setName($from->getProperty('name'));

        $post = new FacebookPost();
        $post
            ->setIdentifier($graphObject->getProperty('id'))
            ->setMessage($graphObject->getProperty('message'))
            ->setAuthor($author)
            ->setCreatedAt(new \DateTime($graphObject->getProperty('created_time')))
        ;

        return $post;
    }

    public function createFromTwitterApiData(array $data)
    {
        $tweet = new Tweet();

        $tweet
            ->setIdentifier($data['id'])
            ->setMessage($data['text'])
            ->setCreatedAt(new \DateTime($data['created_at']))
        ;

        return $tweet;
    }

    public function createFromInstagramApiData(array $data)
    {
        $instagramPost = new InstagramPost();

        $author = new Author();
        $author
            ->setName($data['caption']['from']['username'])
            ->setIdentifier($data['caption']['from']['id'])
        ;

        $instagramPost
            ->setIdentifier($data['caption']['id'])
            ->setMessage($data['caption']['text'])
            ->setCreatedAt(new \DateTime($data['caption']['created_time']))
            ->setAuthor($author)
        ;

        return $instagramPost;
    }
}
