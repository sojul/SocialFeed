<?php

namespace Lns\SocialFeed\Model;

class Author implements AuthorInterface
{
    protected $identifier;
    protected $name;
    protected $profilePicture;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(MediaInterface $profilePicture)
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }
}
