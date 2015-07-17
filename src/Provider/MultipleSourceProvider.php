<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\SourceInterface;

class MultipleSourceProvider extends AbstractProvider
{
    protected $sources = array();

    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;
        return $this;
    }

    public function getResult(array $options = array()) {
    }

    public function getName() {
        return 'multiple_source_provider';
    }
}
