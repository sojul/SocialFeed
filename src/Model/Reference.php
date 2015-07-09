<?php

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

    public function getIndices() {
        return $this->indices;
    }

    public function setType($type) {
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
        return $data;
    }

    public function getStartIndice()
    {
        return isset($this->indices[0]) ? $this->indices[0] : null;
    }

    public function getEndIndice()
    {
        return isset($this->indices[1]) ? $this->indices[1] : null;
    }

    public function getLength() {
        $start = $this->getStartIndice();
        $end = $this->getEndIndice();

        return $end - $start;
    }
}
