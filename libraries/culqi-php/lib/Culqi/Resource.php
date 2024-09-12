<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

namespace Culqi;

/**
 * Class Resource
 *
 * @package Culqi
 */

 #[\AllowDynamicProperties]
class Resource extends Client {

    /**
     * Constructor.
     */
    public function __construct($culqi)
    {
        $this->culqi = $culqi;
    }

}
