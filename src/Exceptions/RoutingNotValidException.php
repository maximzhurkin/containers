<?php

namespace Maximzhurkin\Containers\Exceptions;

use RuntimeException;

class RoutingNotValidException extends RuntimeException
{
    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct($registrar)
    {
        parent::__construct(sprintf('Cannot map routes \'%s\', it is not a valid routes class', $registrar));
    }
}
