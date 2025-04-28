<?php

namespace Illuminate\Database\Rethorical\Attributes;

use Attribute;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisStorageType;

#[Attribute(Attribute::TARGET_CLASS)]
class RedisOverrides
{
    public function __construct(
        // The default  is entity_[ENTITY_NAME]. The entity name will be lower snake cased.
        public string           $key = '',
        public RedisStorageType $storageType = RedisStorageType::Key,
    )
    {}
}