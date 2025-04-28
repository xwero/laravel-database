<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes;

use Illuminate\Database\Rethorical\EntityBase;
use Illuminate\Database\Rethorical\Exceptions\GetQueryMethodNotImplemented;
use Illuminate\Database\Rethorical\Exceptions\ValidateConnectionMethodNotImplementedExceptiion;
use Illuminate\Database\Rethorical\Exceptions\ValidateEntityMethodNotImplemented;

abstract class RelationshipBase
{
    public function __construct(
        public EntityBase $from,
        public string $to,
        public string $connection,
    )
    {
        $this->validateToEntity($to);
        $this->validateConnection($connection);


    }

    public function getQuery()
    {
        throw new GetQueryMethodNotImplemented();
    }

    protected function validateToEntity(string $entity)
    {
        throw new ValidateEntityMethodNotImplemented();
    }

    protected function validateConnection(string $connection)
    {
        throw new ValidateConnectionMethodNotImplementedExceptiion();
    }
}