<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Redis;

use Illuminate\Database\Rethorical\QueryBase;

class RedisQuery extends QueryBase
{
    public function __construct(
        public RedisCommand $command,
        array $parameters = [],
    )
    {
        $this->parameters = $parameters;
    }
}