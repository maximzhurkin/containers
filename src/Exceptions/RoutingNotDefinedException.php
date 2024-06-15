<?php

namespace Maximzhurkin\Containers\Exceptions;

use RuntimeException;

class RoutingNotDefinedException extends RuntimeException
{
    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct($registrar)
    {
        parent::__construct(sprintf('Routing class \'%s\' not defined', $registrar));
    }
}
