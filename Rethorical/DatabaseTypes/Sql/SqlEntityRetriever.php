<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Sql;

use Illuminate\Database\Rethorical\DatabaseTypes\DatabaseEntityRetrieverBase;
use Override;

class SqlEntityRetriever extends DatabaseEntityRetrieverBase
{
    #[Override]
    protected function buildQueries()
    {
        $query = 'select ';

        $this->entity
    }
}