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

class Reference implements ReferenceInterface
{
    protected $indices = array();
    protected $type;
    protected $data = array();

    public function setIndices(array $indices)
    {
        $this->indices = $indices;

        return $this;
    }

    public function getIndices()
    {
        return $this->indices;
    }

    public function setType($type)
    {
        ReferenceType::assertExists($type);
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStartIndice()
    {
        return isset($this->indices[0]) ? $this->indices[0] : null;
    }

    public function getEndIndice()
    {
        return isset($this->indices[1]) ? $this->indices[1] : null;
    }

    public function getLength()
    {
        $start = $this->getStartIndice();
        $end = $this->getEndIndice();

        return $end - $start;
    }
}
