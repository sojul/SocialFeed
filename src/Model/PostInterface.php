<?php

namespace Lns\SocialFeed\Model;

interface PostInterface
{
    public function getIdentifier();
    public function getMessage();
    public function getAuthor();
    public function getCreatedAt();
    public function setMessage($message);
    public function setCreatedAt(\DateTime $dateTime);
    public function setAuthor(AuthorInterface $author);
    public function addMedia(MediaInterface $media);
    public function getMedias();
    public function addReference(ReferenceInterface $reference);
    public function getReferences();
    public function getType();
    public function getUniqueIdentifier();
}
