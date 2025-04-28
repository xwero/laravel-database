<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Sql;

use Illuminate\Database\Rethorical\Attributes\SqlOverrides;
use Illuminate\Database\Rethorical\DatabaseTypes\RelationshipBase;
use Override;

class SqlRelationship extends RelationshipBase
{

    #[Override]
    protected function validateToEntity(string $entity)
    {
        $reflection = new \ReflectionClass($entity);

        if(count($reflection->getAttributes(SqlOverrides::class)) == 0) {
            throw new \InvalidArgumentException("$entity is not a SqlEntity");
        }
    }

    #[Override]
    protected function validateConnection(string $connection)
    {
        $reflection = new \ReflectionClass($connection);

        if($reflection->getParentClass()->getName() != SqlConnection::class) {
            throw new \InvalidArgumentException("$connection is not a SqlConnection");
        }
    }
}