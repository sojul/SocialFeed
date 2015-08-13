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

/**
 * Author.
 */
class Author implements AuthorInterface
{
    protected $identifier;
    protected $name;
    protected $username;
    protected $profilePicture;
    protected $link;
    protected $properties = array();

    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * setIdentifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * setName.
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * setUsername.
     *
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * setProfilePicture.
     *
     * @param MediaInterface $profilePicture
     */
    public function setProfilePicture(MediaInterface $profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    /**
     * setLink.
     *
     * @param $link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * getProperty.
     *
     * @param $propertyKey
     */
    public function getProperty($propertyKey)
    {
        return isset($this->properties[$propertyKey]) ? $this->properties[$propertyKey] : null;
    }

    /**
     * setProperty.
     *
     * @param $propertyKey
     * @param $propertyValue
     */
    public function setProperty($propertyKey, $propertyValue)
    {
        $this->properties[$propertyKey] = $propertyValue;

        return $this;
    }
}
