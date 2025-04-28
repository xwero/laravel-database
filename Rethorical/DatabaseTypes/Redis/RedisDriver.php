<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Redis;

use Illuminate\Database\Rethorical\DatabaseDriver;
use Illuminate\Database\Rethorical\QueryBase;

class RedisDriver implements DatabaseDriver
{
    private $connection;


    public function __construct(array $config)
    {
        $this->connection = $this->connect($config);
    }

    public function connect(array $config)
    {

    }

    public function executeQuery(QueryBase $query)
    {
        // TODO: Implement executeQuery() method.
    }

    public function disconnect()
    {
        $this->connection->close();
    }
}