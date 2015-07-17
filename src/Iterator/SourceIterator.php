<?php

namespace Lns\SocialFeed\Iterator;

use Lns\SocialFeed\SourceInterface;

/**
 * Iterate over source provider result sets
 */
class SourceIterator implements \Iterator
{
    public $currentResultSet = null;
    public $position = 0;

    /**
     * __construct
     *
     * @param SourceInterface $source
     */
    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function current()
    {
        if($this->position == 0) {
            $this->next();
        }

        return $this->currentResultSet;
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        if($this->currentResultSet && !$this->currentResultSet->hasNextResult()) {
            $this->currentResultSet = false;
            $this->position++;
            return;
        }

        $provider = $this->source->getProvider();

        $options = $this->source->getOptions();

        // merge options
        if($this->currentResultSet) {
            $options = array_merge($options, $this->currentResultSet->getNextResultOptions());
        }

        $this->currentResultSet = $provider->getResult($options);

        $this->position++;
    }

    public function valid()
    {
       return ($this->position == 0) || $this->currentResultSet != false;
    }

    public function rewind()
    {
        $this->currentResultSet = null;
        $this->position = 0;
    }
}
