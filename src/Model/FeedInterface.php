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

interface FeedInterface
{
    /**
     * addPost.
     *
     * @param PostInterface $post
     *
     * @return self
     */
    public function addPost(PostInterface $post);

    /**
     * getPost.
     *
     * @param string|int $identifier
     *
     * @return PostInterface $post
     */
    public function getPost($identifier);

    /**
     * first.
     *
     * @return PostInterface $post
     */
    public function first();

    /**
     * last.
     *
     * @return PostInterface $post
     */
    public function last();
}
