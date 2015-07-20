<?php

namespace Lns\SocialFeed\Factory;

use Lns\SocialFeed\Model\InstagramPost;
use Lns\SocialFeed\Model\Author;
use Lns\SocialFeed\Model\Tweet;
use Lns\SocialFeed\Model\Media;
use Lns\SocialFeed\Model\Reference;
use Lns\SocialFeed\Model\ReferenceType;

class InstagramPostFactory implements PostFactoryInterface
{
    /**
     * create
     *
     * @param array $data
     * @return InstagramPost $post
     */
    public function create(array $data)
    {
        $instagramPost = new InstagramPost();

        $author = new Author();
        $author
            ->setName($data['caption']['from']['full_name'])
            ->setIdentifier($data['caption']['from']['id'])
            ->setLink('https://instagram.com/' . $data['caption']['from']['username'])
            ->setUsername($data['caption']['from']['username'])
        ;

        $media = new Media();
        $media->setUrl($data['user']['profile_picture']);
        $author->setProfilePicture($media);

        $instagramPost
            ->setIdentifier($data['caption']['id'])
            ->setMessage($data['caption']['text'])
            ->setCreatedAt(\DateTime::createFromFormat('U', $data['caption']['created_time']))
            ->setAuthor($author)
        ;

        $this->addPostMedias($instagramPost, $data);

        return $instagramPost;
    }

    protected function addPostMedias(&$post, $data) {

        // we fetch standard_resolution image
        $imageData = $data['images']['standard_resolution'];
        $media = new Media();

        $media
            ->setUrl($imageData['url'])
            ->setLink($data['link'])
            ->setWidth($imageData['width'])
            ->setHeight($imageData['height'])
        ;

        $post->addMedia($media);
    }
}
