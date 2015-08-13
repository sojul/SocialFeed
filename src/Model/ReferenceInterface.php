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
    public function setIndices(array $indices);
    public function getIndices();
    public function setType($type);
    public function getType();
    public function setData(array $data);
    public function getData();
    public function getStartIndice();
    public function getEndIndice();
    public function getLength();
}
