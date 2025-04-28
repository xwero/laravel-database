<?php

namespace Database\Rethorical;

use Illuminate\Database\Rethorical\Conditions\AddFieldValue;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisOneToMany;
use Illuminate\Database\Rethorical\DatabaseTypes\Redis\RedisRelationship;
use Illuminate\Database\Rethorical\DatabaseTypes\Sql\SqlEntity;
use Illuminate\Database\Rethorical\DatabaseTypes\Sql\SqlOneToMany;
use Illuminate\Database\Rethorical\DatabaseTypes\Sql\SqlQuery;
use Illuminate\Database\Rethorical\DatabaseTypes\Sql\SqlRelationship;
use Illuminate\Database\Rethorical\EntityManipulator;
use Illuminate\Database\Rethorical\EntityRetriever;
use PHPUnit\Framework\TestCase;


class RethoricalSqlTest extends TestCase
{
    public function testSqlSelect()
    {
        $query = new EntityRetriever(Author::class)->getQuery();

        $this->assertInstanceOf(SqlQuery::class, $query);
        $this->assertSame('select name from books;', $query->query);
        $this->assertEmpty($query->parameters);
    }

    public function testSqlInsert()
    {
        $query = EntityManipulator::insert(Author::class)
                    ->addCondition(new AddFieldValue('name', 'test'))
                    ->getQuery();

        $this->assertInstanceOf(SqlQuery::class, $query);
        $this->assertSame('insert into authors (name) values (:name);', $query->query);
        $this->assertSame([':name' => 'test'], $query->parameters);
    }

    public function testSqlUpdate()
    {
        $query = EntityManipulator::update(Author::class, 1)
            ->addCondition(new AddFieldValue('name', 'test'))
            ->getQuery();

        $this->assertInstanceOf(SqlQuery::class, $query);
        $this->assertSame('update authors set name = :name where id = :id;', $query->query);
        $this->assertSame([':name' => 'test', ':id' => 1], $query->parameters);
    }

    public function testSqlDelete()
    {
        $query = EntityManipulator::delete(Author::class, 1)->getQuery();

        $this->assertInstanceOf(SqlQuery::class, $query);
        $this->assertSame('delete from authors where id = :id;', $query->query);
        $this->assertSame([':id' => 1], $query->parameters);
    }
}


class Author extends SqlEntity
{
    public static string $name = '';
}

class Book extends SqlEntity
{
    public string $name = '';

    public function __construct()
    {
        parent::__construct();
        $this->authors = new SqlRelationship($this, Author::class, SqlOneToMany::class);
        $this->comments = new RedisRelationship($this, Comments::class, RedisOneToMany::class);
    }
}
