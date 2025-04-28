<?php

namespace Illuminate\Database\Rethorical;

use Illuminate\Database\Rethorical\Conditions\ConditionBase;
use Illuminate\Database\Rethorical\Conditions\Find;
use InvalidArgumentException;
use ReflectionClass;

class EntityManipulator
{
    protected array $conditions = [];
    protected $executionChain = [];

    public function __construct(
        protected string $entity,
        protected ManipulationType $type,
    )
    {
        $this->validateEntity($entity);

    }

    public static function insert(string $entity)
    {
        return new self($entity, ManipulationType::Insert);
    }

    public static function update(string $entity, string|int $id = 0)
    {
        $instance = new self($entity, ManipulationType::Update);

        if($id === 0) {
            return $instance;
        }

        return $instance->addCondition(new Find($id));
    }

    public static function delete(string $entity, string|int $id = 0)
    {
        $instance = new self($entity, ManipulationType::Delete);

        if($id === 0) {
            return $instance;
        }

        return $instance->addCondition(new Find($id));
    }

    public function addCondition(ConditionBase $condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    public function execute()
    {
        $this->buildQueries();
    }

    public function getQuery() : array|QueryBase
    {
        $this->buildQueries();

        if(count($this->queries) == 1) {
            return $this->queries[0];
        }

        return $this->queries;
    }

    protected function buildQueries() : void
    {

    }

    /**
     * @throws \ReflectionException
     */
    private function validateEntity(string $entity)
    {
        $reflection = new ReflectionClass($entity);

        if($reflection->getParentClass() != EntityBase::class) {
            throw new InvalidArgumentException((string)$reflection->getName().' does not extend '.EntityBase::class);
        }
    }
}