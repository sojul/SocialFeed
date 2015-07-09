<?php

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
