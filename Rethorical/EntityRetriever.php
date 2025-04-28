<?php

namespace Illuminate\Database\Rethorical;

use InvalidArgumentException;
use ReflectionClass;

class EntityRetriever
{
    protected array $conditions = [];
    protected ExecutionChain $executionChain;
    
    public function __construct(
        protected string $entity,
    )
    {
        $this->validateEntity($entity);
        
    }
    
    public function addCondition(string $condition) : self
    {
        $this->validateCondition($condition);
        
        $this->conditions[] = $condition;
        
        return $this;
    }
    
    public function get()
    {
        $this->buildQueries();


    }

    public function getQuery() : array|QueryBase
    {
        $this->buildQueries();

        if(count($this->executionChain) == 1) {
            $this->executionChain->getIterator()->rewind();

            return $this->executionChain->getIterator()->current();
        }

        return $this->executionChain->toArray();
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

    protected function validateCondition(string $condition)
    {
    }
}