<?php

namespace Lns\SocialFeed\Model;

interface MediaInterface
{
    public function getUrl();
    public function getWidth();
    public function getHeight();
    public function setUrl($url);
    public function setWidth($width);
    public function setHeight($height);
}
