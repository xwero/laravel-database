<?php

namespace Illuminate\Database\Rethorical;

use AllowDynamicProperties;
use Illuminate\Database\Rethorical\Attributes\ProcessAttributes;
use Illuminate\Database\Rethorical\DatabaseTypes\RelationshipBase;
use Illuminate\Database\Rethorical\Exceptions\BaseClassException;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

#[AllowDynamicProperties]
abstract class EntityBase
{
    public string|int $id = 0;

    public function __construct()
    {
        $reflection = new ReflectionClass(static::class);
        $this->processProperties($reflection);
        $this->processAttributes($reflection);
    }

    protected function processAttributes(ReflectionClass $reflection)
    {
        $instance = $reflection->newInstanceWithoutConstructor();

        $this->metadata = [];

        foreach($reflection->getMethods(ReflectionMethod::IS_PROTECTED) as $method ) {
            if(count($method->getAttributes(ProcessAttributes::class)) > 0) {
                $method->invoke($instance, $reflection, $this);
            }
        }
    }

    protected function processProperties(ReflectionClass $reflection)
    {
        $instance = $reflection->newInstanceWithoutConstructor();

        $this->fields = [];

        foreach($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property ) {
            if(!$property->getValue($instance) instanceof RelationshipBase) {
                $name = $property->getName();
                $this->fields[] = Str::snake($name);
            }
        }

        $parent = $reflection->getParentClass();

        if($parent->getName() == EntityBase::class) {
            throw new BaseClassException();
        }

        $this->database = str_replace('Entity', '', $parent->getShortName());
    }
}