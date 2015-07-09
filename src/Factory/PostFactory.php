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

        $mediaDatas = array();
        $entities = array();


        if(isset($data['entities']['media'])) {
            $mediaDatas += $data['entities']['media'];
        }

        if(isset($data['extended_entities']['media'])) {
            $mediaDatas += $data['extended_entities']['media'];
        }

        $replacements = array();

        $typeMap = array(
            'urls'          => ReferenceType::URL,
            'user_mentions' => ReferenceType::USER,
            'hashtags'      => ReferenceType::HASHTAG,
            'video'         => ReferenceType::VIDEO,
        );

        foreach($data['entities'] as $entityType => $entities) {
            foreach($entities as $entity) {
                $reference = new Reference();
                $reference
                    ->setIndices($entity['indices'])
                    ->setType($typeMap[$entityType])
                    ->setData($entity);

                $tweet->addReference($reference);

                //$originalValue = mb_substr($data['text'], $start, $length, "UTF-8");
                //$replacements[$originalValue] = $this->getReplacementValue($originalValue, $entityType, $entity);
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

        foreach($mediaDatas as $mediaData) {
            $media = new Media();
            $media->setUrl($mediaData['media_url']);
            $media->setLink($mediaData['expanded_url']);
            $tweet->addMedia($media);
        }

        return $tweet;
    }

    protected function getReplacementValue($orginalValue, $entityType, $entity) {
        switch ($entityType) {
            case 'urls':
                return sprintf('<a href="%s" target="_blank">%s</a>', $entity['expanded_url'], $entity['display_url']);
                break;
            case 'user_mentions':
                return sprintf('<a href="https://www.twitter.com/%s" target="_blank">%s</a>', $entity['screen_name'], $orginalValue);
                break;
            case 'hashtags':
                return sprintf('<a href="https://twitter.com/hashtag/%s" target="_blank">%s</a>', $entity['text'], $orginalValue);
                break;
            case 'video':
                return sprintf('<a href="%s" target="_blank">%s</a>', $entity['expanded_url'], $entity['display_url']);
                break;
            default:
                return $orginalValue;
                break;
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

        // we fetch standard_resolution image
        $imageData = $data['images']['standard_resolution'];
        $media = new Media();

        $media
            ->setUrl($imageData['url'])
            ->setLink($data['link'])
            ->setWidth($imageData['width'])
            ->setHeight($imageData['height'])
        ;

        $instagramPost->addMedia($media);

        return $instagramPost;
    }
}
