<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Sql;

use Illuminate\Database\Rethorical\Attributes\ProcessAttributes;
use Illuminate\Database\Rethorical\EntityBase;
use ReflectionClass;

class SqlEntity extends EntityBase
{
    #[ProcessAttributes]
    protected function overrideOrSetDefaults(ReflectionClass $reflection, EntityBase &$instance)
    {

    }
}