<?php

namespace Lns\SocialFeed\Model\Pagination;

class Token implements TokenInterface
{
    protected $parameters;

    /**
     * __construct
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array()) {
        $this->parameters = $parameters;
    }

    public function __toString() {
        base64_encode(json_encode($this->parameters));
    }

    /**
     * createFromString
     *
     * @param mixed $string
     */
    public static function createFromString($string) {
        return json_decode(base64_decode($string));
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
