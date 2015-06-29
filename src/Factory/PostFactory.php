<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;
use Lns\SocialFeed\Model\InstagramPost;
use Lns\SocialFeed\Model\Author;
use Lns\SocialFeed\Model\Tweet;
use Lns\SocialFeed\Model\Media;

class PostFactory implements PostFactoryInterface
{
    /**
     * createFacebookPostFromOpenGraphObject
     *
     * @param GraphObject $graphObject
     * @return FacebookPost $post
     */
    public function createFacebookPostFromOpenGraphObject(GraphObject $graphObject)
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

    /**
     * createTweetFromApiData
     *
     * @param array $data
     * @return Tweet $post
     */
    public function createTweetFromApiData(array $data)
    {
        $tweet = new Tweet();

        $tweet
            ->setIdentifier($data['id'])
            ->setMessage($data['text'])
            ->setCreatedAt(new \DateTime($data['created_at']))
        ;

        // add medias
        if(isset($data['entities']['media'])) {
            foreach($data['entities']['media'] as $mediaData) {
                $media = new Media();
                $media->setUrl($mediaData['media_url']);
                $tweet->addMedia($media);
            }
        }

        return $tweet;
    }

    /**
     * createInstagramPostFromApiData
     *
     * @param array $data
     * @return InstagramPost $post
     */
    public function createInstagramPostFromApiData(array $data)
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
            ->setCreatedAt(\DateTime::createFromFormat('U', $data['caption']['created_time']))
            ->setAuthor($author)
        ;

        // add medias
        if(isset($data['images'])) {
            foreach($data['images'] as $imageData) {
                $media = new Media();
                $media->setUrl($imageData['url']);
                $media->setWidth($imageData['width']);
                $media->setHeight($imageData['height']);
                $instagramPost->addMedia($media);
            }
        }

        return $instagramPost;
    }
}
