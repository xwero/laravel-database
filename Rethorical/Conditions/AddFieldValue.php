<?php

namespace Illuminate\Database\Rethorical\Conditions;

class AddFieldValue extends ConditionBase
{
    public function __construct(
        public string $field,
        public mixed $value,
    )
    {}
}