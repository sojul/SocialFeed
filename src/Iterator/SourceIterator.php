<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Iterator;

use Lns\SocialFeed\SourceInterface;

/**
 * Iterate over source posts.
 */
class SourceIterator implements \Iterator
{
    public $currentResultSet = null;
    public $position = 0;

    /**
     * __construct.
     *
     * @param SourceInterface $source
     */
    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function current()
    {
        if (!$this->currentResultSet) {
            return;
        }

        return $this->currentResultSet->getIterator()->current();
    }

    public function key()
    {
        return $this->position;
    }

    protected function loadNextResultSet()
    {
        if ($this->currentResultSet && !$this->currentResultSet->hasNextResultSet()) {
            $this->currentResultSet = null;
            ++$this->position;

            return false;
        }

        $provider = $this->source->getProvider();

        $options = $this->source->getOptions();

        // merge options
        if ($this->currentResultSet) {
            $options = array_merge($options, $this->currentResultSet->getNextResultSetOptions());
        }

        $this->currentResultSet = $provider->getResult($options);

        return true;
    }

    public function next()
    {
        $this->currentResultSet->getIterator()->next();

        if (!$this->currentResultSet->getIterator()->valid()) {
            $this->loadNextResultSet();
        }

        ++$this->position;
    }

    public function valid()
    {
        return $this->currentResultSet && $this->currentResultSet->getIterator()->valid();
    }

    public function rewind()
    {
        $this->currentResultSet = null;
        $this->position = 0;

        $this->loadNextResultSet();
    }
}
