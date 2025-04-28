<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Sql;

use Illuminate\Database\Rethorical\QueryBase;

class SqlQuery extends QueryBase
{
    public function __construct(
        public string $query,
        array $parameters = [],
    )
    {
        $this->parameters = $parameters;
    }
}