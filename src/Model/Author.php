<?php

namespace Lns\SocialFeed\Model;

class Author implements AuthorInterface
{
    protected $identifier;
    protected $name;
    protected $profilePicture;
    protected $link;
    protected $properties = array();

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

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function getProperty($propertyKey)
    {
        return isset($this->properties[$propertyKey]) ? $this->properties[$propertyKey] : null;
    }

    public function setProperty($propertyKey, $propertyValue)
    {
        $this->properties[$propertyKey] = $propertyValue;
        return $this;
    }
}
