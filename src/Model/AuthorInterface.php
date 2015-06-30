<?php

namespace Lns\SocialFeed\Model;

interface AuthorInterface
{
    public function getName();
    public function setName($name);
    public function getIdentifier();
    public function setIdentifier($identifier);
    public function getProfilePicture();
    public function setProfilePicture(MediaInterface $media);
}

