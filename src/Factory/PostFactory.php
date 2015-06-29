<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;
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
        $post->setIdentifier($graphObject->getProperty('id'));
        $post->setMessage($graphObject->getProperty('message'));
        $post->setAuthor($author);

        return $post;
    }

    public function createFromTwitterApiData(array $data)
    {
        $tweet = new Tweet();

        $tweet->setIdentifier($data['id']);
        $tweet->setMessage($data['text']);

        return $tweet;
    }
}
