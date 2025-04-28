<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes;

use Illuminate\Database\Rethorical\EntityBase;
use Illuminate\Database\Rethorical\Exceptions\GetQueryMethodNotImplemented;

abstract class ConnectionBase
{
    public function __construct(
        private EntityBase $from,
        private EntityBase $to,
    )
    {
    }

    public function getQuery()
    {
        throw new GetQueryMethodNotImplemented();
    }
}