<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Factory;

use Lns\SocialFeed\Model\Author;
use Lns\SocialFeed\Model\InstagramPost;
use Lns\SocialFeed\Model\Media;

/**
 * InstagramPostFactory.
 */
class InstagramPostFactory implements PostFactoryInterface
{
    /**
     * create.
     *
     * @param array $data
     *
     * @return InstagramPost $post
     */
    public function create(array $data)
    {
        $instagramPost = new InstagramPost();

        $author = new Author();
        $author
            ->setName($data['caption']['from']['full_name'])
            ->setIdentifier($data['caption']['from']['id'])
            ->setLink('https://instagram.com/'.$data['caption']['from']['username'])
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

    /**
     * addPostMedias.
     *
     * @param $post
     * @param $data
     */
    protected function addPostMedias(&$post, $data)
    {

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
