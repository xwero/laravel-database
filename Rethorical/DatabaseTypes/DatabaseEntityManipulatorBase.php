<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes;

use Illuminate\Database\Rethorical\EntityBase;
use Illuminate\Database\Rethorical\Exceptions\ExecuteMethodNotImplementedException;

abstract class DatabaseEntityManipulatorBase
{
    public function __construct(
        private EntityBase $entity,
        private array $conditions
    )
    {}

    public function execute()
    {
        throw new ExecuteMethodNotImplementedException();
    }
}