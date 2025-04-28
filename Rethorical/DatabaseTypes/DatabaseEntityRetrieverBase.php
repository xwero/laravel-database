<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes;

use Illuminate\Database\Rethorical\EntityBase;
use Illuminate\Database\Rethorical\Exceptions\GetMethodNotImplemented;

abstract class DatabaseEntityRetrieverBase
{
    public function __construct(
        protected EntityBase $entity,
        private array $conditions
    )
    {}

    public function get()
    {
        throw new GetMethodNotImplemented();
    }
}