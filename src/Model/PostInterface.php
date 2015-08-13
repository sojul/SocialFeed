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

interface PostInterface
{
    public function getIdentifier();
    public function getMessage();
    public function getAuthor();
    public function getCreatedAt();
    /**
     * setMessage.
     *
     * @param $message
     */
    public function setMessage($message);
    public function setCreatedAt(\DateTime $dateTime);
    /**
     * setAuthor.
     *
     * @param AuthorInterface $author
     */
    public function setAuthor(AuthorInterface $author);
    public function addMedia(MediaInterface $media);
    public function getMedias();
    /**
     * addReference.
     *
     * @param ReferenceInterface $reference
     */
    public function addReference(ReferenceInterface $reference);
    public function getReferences();
    public function getType();
    public function getUniqueIdentifier();
}
