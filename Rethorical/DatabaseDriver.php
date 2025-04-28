<?php

namespace Illuminate\Database\Rethorical;

interface DatabaseDriver
{
    public function connect(array|string $config);

    public function executeQuery(QueryBase $query);

    public function disconnect();
}