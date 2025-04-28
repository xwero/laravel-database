<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Sql;

use Illuminate\Database\Rethorical\DatabaseDriver;
use Illuminate\Database\Rethorical\QueryBase;

class SqlDriver implements DatabaseDriver
{
    private $connection;


    public function __construct(array $config)
    {
        $this->connection = $this->connect($config);
    }

    public function connect(array|string $config)
    {

    }

    public function executeQuery(QueryBase $query)
    {
        // TODO: Implement executeQuery() method.
    }

    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }
}