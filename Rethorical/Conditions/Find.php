<?php

namespace Illuminate\Database\Rethorical\Conditions;

use Illuminate\Database\Rethorical\Conditions\ConditionBase;

class Find extends ConditionBase
{
    public function __construct(
        public string|int $id,
    )
    {}
}