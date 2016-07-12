<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Model\Pagination;

class Token implements TokenInterface
{
    protected $parameters;

    /**
     * __construct.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    public function __toString()
    {
        base64_encode(json_encode($this->parameters));
    }

    /**
     * createFromString.
     *
     * @param mixed $string
     */
    public static function createFromString($string)
    {
        return json_decode(base64_decode($string, true));
    }

    /**
     * Get parameters.
     *
     * @return parameters.
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
