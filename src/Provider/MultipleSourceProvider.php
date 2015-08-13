<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\SourceInterface;

/**
 * MultipleSourceProvider.
 */
class MultipleSourceProvider extends AbstractProvider
{
    protected $sources = array();

    /**
     * addSource.
     *
     * @param SourceInterface $source
     */
    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * getResult.
     *
     * @param array $options
     */
    public function getResult(array $options = array())
    {
    }

    public function getName()
    {
        return 'multiple_source_provider';
    }
}
