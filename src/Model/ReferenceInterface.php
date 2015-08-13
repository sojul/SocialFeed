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

interface ReferenceInterface
{
    /**
     * setIndices.
     *
     * @param array $indices
     */
    public function setIndices(array $indices);
    public function getIndices();
    /**
     * setType.
     *
     * @param $type
     */
    public function setType($type);
    public function getType();
    /**
     * setData.
     *
     * @param array $data
     */
    public function setData(array $data);
    public function getData();
    public function getStartIndice();
    public function getEndIndice();
    public function getLength();
}
