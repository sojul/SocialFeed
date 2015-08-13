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

interface AuthorInterface
{
    public function getName();
    /**
     * setName.
     *
     * @param $name
     */
    public function setName($name);
    public function getUsername();
    /**
     * setUsername.
     *
     * @param $username
     */
    public function setUsername($username);
    public function getIdentifier();
    /**
     * setIdentifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier);
    public function getProfilePicture();
    /**
     * setProfilePicture.
     *
     * @param MediaInterface $media
     */
    public function setProfilePicture(MediaInterface $media);
    public function getLink();
    /**
     * setLink.
     *
     * @param $link
     */
    public function setLink($link);
    public function setProperty($propertyKey, $propertyValue);
    /**
     * getProperty.
     *
     * @param $propertyKey
     */
    public function getProperty($propertyKey);
}
