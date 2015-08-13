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
    public function setName($name);
    public function getUsername();
    public function setUsername($username);
    public function getIdentifier();
    public function setIdentifier($identifier);
    public function getProfilePicture();
    public function setProfilePicture(MediaInterface $media);
    public function getLink();
    public function setLink($link);
    public function setProperty($propertyKey, $propertyValue);
    public function getProperty($propertyKey);
}
