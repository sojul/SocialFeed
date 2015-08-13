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

interface MediaInterface
{
    public function getUrl();
    public function getWidth();
    public function getHeight();
    /**
     * setUrl.
     *
     * @param $url
     */
    public function setUrl($url);
    public function setWidth($width);
    /**
     * setHeight.
     *
     * @param $height
     */
    public function setHeight($height);
    public function getLink();
    /**
     * setLink.
     *
     * @param $link
     */
    public function setLink($link);
}
