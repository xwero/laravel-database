<?php

namespace Illuminate\Database\Eloquent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class BuilderExtension
{
    public mixed $identifiers;

    public function __construct(mixed ...$identifiers)
    {
        $this->identifiers = $identifiers;
    }
}