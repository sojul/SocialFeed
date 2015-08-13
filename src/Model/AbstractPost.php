<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Model;

abstract class AbstractPost implements PostInterface
{
    protected $identifier;
    protected $message;
    protected $author;
    protected $createdAt;
    protected $medias = array();
    protected $references = array();
    protected $url;
    protected $type;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(AuthorInterface $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function addMedia(MediaInterface $media)
    {
        $this->medias[] = $media;

        return $this;
    }

    public function getMedias()
    {
        return $this->medias;
    }

    public function addReference(ReferenceInterface $reference)
    {
        $this->references[] = $reference;

        return $this;
    }

    public function getReferences()
    {
        return $this->references;
    }

    public function getUniqueIdentifier()
    {
        return $this->getType().'_'.$this->getIdentifier();
    }
}
