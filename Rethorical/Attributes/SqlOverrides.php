<?php

namespace Illuminate\Database\Rethorical\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SqlOverrides
{
    public function __construct(
        // The default is the plural of the entity name.
        public string $table = '',
    )
    {}
}