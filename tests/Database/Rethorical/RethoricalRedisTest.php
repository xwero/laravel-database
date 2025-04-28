<?php

namespace Database\Rethorical;

use Illuminate\Database\Rethorical\Attributes\RedisOverrides;
use Illuminate\Database\Rethorical\Conditions\AddFieldValue;
use Illuminate\Database\Rethorical\Conditions\AddRedisKey;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisCommand;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisEntity;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisQuery;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisStorageType;
use Illuminate\Database\Rethorical\EntityManipulator;
use Illuminate\Database\Rethorical\EntityRetriever;
use PHPUnit\Framework\TestCase;


class RethoricalRedisTest extends TestCase
{
    public function testRedisKeySelect()
    {
        $query = new EntityRetriever(Nice::class)->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Get, $query->command);
        $this->assertSame(['entity_nice'], $query->parameters);
    }

    public function testRedisKeyInsert()
    {
        $query = EntityManipulator::insert(Nice::class)
            ->addCondition(new AddRedisKey('test'))
            ->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Set, $query->command);
        $this->assertSame(['entity_nice', 'test'], $query->parameters);
    }

    public function testRedisKeyUpdate()
    {
        $query = EntityManipulator::update(Nice::class)
            ->addCondition(new AddRedisKey('test'))
            ->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Set, $query->command);
        $this->assertSame(['entity_nice', 'test'], $query->parameters);
    }

    public function testRedisKeyDelete()
    {
        $query = EntityManipulator::delete(Nice::class)->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Del, $query->command);
        $this->assertSame(['entity_comments'], $query->parameters);
    }

    public function testRedisHashSelect()
    {
        $query = new EntityRetriever(Comments::class)->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Hkeys, $query->command);
        $this->assertSame(['entity_comments'], $query->parameters);
    }

    public function testRedishashInsert()
    {
        $query = EntityManipulator::insert(Comments::class)
            ->addCondition(new AddRedisKey('test'))
            ->getQuery();

        $this->assertIsArray($query);

        $first = $query[0];

        $this->assertInstanceOf(RedisQuery::class, $first);
        $this->assertSame(RedisCommand::Incr, $first->command);
        $this->assertSame(['entity_comments:id'], $first->parameters);

        $second = $query[1];

        $this->assertInstanceOf(RedisQuery::class, $second);
        $this->assertSame(RedisCommand::HmSet, $second->command);
        $this->assertSame(["entity_comments:\$id"], $second->parameters);
    }

    public function testRedishashUpdate()
    {
        $query = EntityManipulator::update(Comments::class, 1)
            ->addCondition(new AddFieldValue('name', 'test'))
            ->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Hset, $query->command);
        $this->assertSame(['entity_comments:1', 'name', 'test'], $query->parameters);
    }

    public function testRedisHashDelete()
    {
        $query = EntityManipulator::delete(Comments::class, 1)->getQuery();

        $this->assertInstanceOf(RedisQuery::class, $query);
        $this->assertSame(RedisCommand::Del, $query->command);
        $this->assertSame(['entity_comments:1'], $query->parameters);
    }
}

class Nice extends RedisEntity
{

}

#[RedisOverrides(storageType: RedisStorageType::Hash)]
class Comments extends RedisEntity
{

}

