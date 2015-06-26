<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;
use Lns\SocialFeed\Model\Author;

class FacebookPostFactory
{
    public function createFromGraphObject(GraphObject $graphObject)
    {
        $facebookPost = new FacebookPost();

        $author = new Author();

        $author->setName($graphObject->getProperty('from')->getProperty('name'));
        $author->setIdentifier($graphObject->getProperty('from')->getProperty('id'));

        $facebookPost
            ->setMessage($graphObject->getProperty('message'))
            ->setIdentifier($graphObject->getProperty('id'))
            ->setAuthor($author);

        return $facebookPost;
    }
}
