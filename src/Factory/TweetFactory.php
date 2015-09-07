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
use Lns\SocialFeed\Model\Media;
use Lns\SocialFeed\Model\Reference;
use Lns\SocialFeed\Model\ReferenceType;
use Lns\SocialFeed\Model\Tweet;

/**
 * TweetFactory.
 */
class TweetFactory implements PostFactoryInterface
{
    /**
     * create.
     *
     * @param array $data
     *
     * @return Tweet $post
     */
    public function create(array $data)
    {
        $tweet = new Tweet();

        $media = new Media();
        $media->setUrl($data['user']['profile_image_url']);

        $author = new Author();
        $author->setProfilePicture($media);
        $author->setIdentifier($data['user']['id']);
        $author->setName($data['user']['name']);
        $author->setLink('https://twitter.com/'.$data['user']['screen_name']);
        $author->setUsername($data['user']['screen_name']);

        $tweet
            ->setIdentifier($data['id'])
            ->setMessage($data['text'])
            ->setCreatedAt(new \DateTime($data['created_at']))
            ->setAuthor($author);

        $this->addTweetReferences($tweet, $data);
        $this->addTweetMedias($tweet, $data);

        return $tweet;
    }

    /**
     * addTweetMedias.
     *
     * @param $tweet
     * @param $data
     */
    protected function addTweetMedias(&$tweet, $data)
    {
        if (!isset($data['entities']['media'])) {
            return;
        }

        foreach ($data['entities']['media'] as $mediaData) {
            $media = new Media();
            $media->setUrl($mediaData['media_url']);
            $media->setLink($mediaData['expanded_url']);
            $tweet->addMedia($media);
        }
    }

    /**
     * addTweetReferences.
     *
     * @param $tweet
     * @param $data
     */
    protected function addTweetReferences(&$tweet, $data)
    {
        $typeMap = array(
            'urls' => ReferenceType::URL,
            'user_mentions' => ReferenceType::USER,
            'hashtags' => ReferenceType::HASHTAG,
            'video' => ReferenceType::VIDEO,
            'media' => ReferenceType::MEDIA,
            'photo' => ReferenceType::MEDIA,
        );

        foreach ($data['entities'] as $entityType => $entities) {
            foreach ($entities as $entity) {
                $reference = new Reference();
                $reference
                    ->setIndices($entity['indices'])
                    ->setType($typeMap[$entityType])
                    ->setData($entity);

                $tweet->addReference($reference);
            }
        }

        if (isset($data['extended_entities'])) {
            foreach ($data['extended_entities'] as $entities) {
                foreach ($entities as $entity) {
                    $reference = new Reference();
                    $reference
                        ->setIndices($entity['indices'])
                        ->setType($typeMap[$entity['type']])
                        ->setData($entity);

                    $tweet->addReference($reference);
                }
            }
        }
    }
}
