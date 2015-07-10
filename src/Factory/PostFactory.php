<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;
use Lns\SocialFeed\Model\FacebookPost;
use Lns\SocialFeed\Model\InstagramPost;
use Lns\SocialFeed\Model\Author;
use Lns\SocialFeed\Model\Tweet;
use Lns\SocialFeed\Model\Media;
use Lns\SocialFeed\Model\Reference;
use Lns\SocialFeed\Model\ReferenceType;

class PostFactory implements PostFactoryInterface
{
    /**
     * createFacebookPostFromApiData
     *
     * @param array $data
     * @return FacebookPost $post
     */
    public function createFacebookPostFromApiData(array $data)
    {
        $from = $data['from'];

        $author = new Author();
        $author->setIdentifier($from['id']);
        $author->setName($from['name']);
        $author->setLink($from['link']);

        $media = new Media();
        $media->setUrl($from['picture']['data']['url']);
        $media->setLink($from['link']);
        $author->setProfilePicture($media);

        $data['message'] = isset($data['message']) ? $data['message'] : '';

        $post = new FacebookPost();
        $post
            ->setIdentifier($data['id'])
            ->setMessage($data['message'])
            ->setAuthor($author)
            ->setCreatedAt(new \DateTime($data['created_time']))
        ;

        if(isset($data['full_picture'])) {
            $media = new Media();
            $media->setUrl($data['full_picture']);
            $media->setLink($data['link']);
            $post->addMedia($media);
        }

        $this->addFacebookPostReferences($post, $data);

        return $post;
    }

    protected function addFacebookPostReferences(&$post, $data) {
        $typeMap = array(
            'user'  => ReferenceType::USER,
            'page'  => ReferenceType::PAGE,
            'group' => ReferenceType::GROUP,
        );

        if(!isset($data['message_tags'])) {
            return;
        }

        foreach($data['message_tags'] as $messageTagGroup) {
            foreach($messageTagGroup as $messageTag) {
                $reference = new Reference();
                $reference
                    ->setIndices([$messageTag['offset'], $messageTag['offset'] + $messageTag['length']])
                    ->setType($typeMap[$messageTag['type']])
                    ->setData($messageTag);

                $post->addReference($reference);
            }
        }
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

        $media = new Media();
        $media->setUrl($data['user']['profile_image_url']);

        $author = new Author();
        $author->setProfilePicture($media);
        $author->setIdentifier($data['user']['id']);
        $author->setName($data['user']['name']);
        $author->setLink('https://twitter.com/' . $data['user']['screen_name']);
        $author->setUsername($data['user']['screen_name']);

        $tweet
            ->setIdentifier($data['id'])
            ->setMessage($data['text'])
            ->setCreatedAt(new \DateTime($data['created_at']))
            ->setAuthor($author);
        ;

        $this->addTweetReferences($tweet, $data);
        $this->addTweetMedias($tweet, $data);

        return $tweet;
    }

    protected function addTweetMedias(&$tweet, $data) {
        $mediaDatas = array();

        if(isset($data['entities']['media'])) {
            $mediaDatas += $data['entities']['media'];
        }

        if(isset($data['extended_entities']['media'])) {
            $mediaDatas += $data['extended_entities']['media'];
        }

        // add medias
        foreach($mediaDatas as $mediaData) {
            $media = new Media();
            $media->setUrl($mediaData['media_url']);
            $media->setLink($mediaData['expanded_url']);
            $tweet->addMedia($media);
        }
    }

    protected function addTweetReferences(&$tweet, $data) {
        $typeMap = array(
            'urls'          => ReferenceType::URL,
            'user_mentions' => ReferenceType::USER,
            'hashtags'      => ReferenceType::HASHTAG,
            'video'         => ReferenceType::VIDEO,
            'media'         => ReferenceType::MEDIA,
        );

        foreach($data['entities'] as $entityType => $entities) {
            foreach($entities as $entity) {
                $reference = new Reference();
                $reference
                    ->setIndices($entity['indices'])
                    ->setType($typeMap[$entityType])
                    ->setData($entity);

                $tweet->addReference($reference);
            }
        }

        if(isset($data['extended_entities'])) {
            foreach($data['extended_entities'] as $entities) {
                foreach($entities as $entity) {
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

        $this->addInstagramPostMedias($instagramPost, $data);

        return $instagramPost;
    }

    protected function addInstagramPostMedias(&$post, $data) {

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
