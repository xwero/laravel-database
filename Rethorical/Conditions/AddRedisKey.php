<?php

namespace Illuminate\Database\Rethorical\Conditions;



class AddRedisKey extends ConditionBase
{
    public function __construct(public string $value)
    {
    }
}