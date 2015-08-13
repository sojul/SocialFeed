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
 * Media.
 */
class Media implements MediaInterface
{
    protected $url;
    protected $width;
    protected $height;
    protected $link;

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * setUrl.
     *
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    /**
     * setWidth.
     *
     * @param $width
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    /**
     * setHeight.
     *
     * @param $height
     */
    public function setHeight($height)
    {
        $this->height = $height;

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
}
