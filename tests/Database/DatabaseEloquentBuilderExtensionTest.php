<?php

namespace Illuminate\Tests\Database;

use Attribute;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Attributes\BuilderExtension;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\BuilderExtension as BulderExtensionInterface;
use Illuminate\Database\Eloquent\BuilderExtensionType;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class DatabaseEloquentBuilderExtensionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        tap(new DB)->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ])->bootEloquent();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Model::unsetConnectionResolver();
    }

    public function testFindSingleRequiredBuilderExtension()
    {
       $model = new EloquentSingleRequiredBuilderExtensionModel();

       $this->assertTrue($model->hasBuilderExtension(ActiveBuilderExtension::class));
    }

    public function testGlobalScopeIsApplied()
    {
        $model = new EloquentSingleRequiredBuilderExtensionModel();
        $query = $model->newQuery();
        $this->assertSame('select * from "table" where "active" = ?', $query->toSql());
        $this->assertEquals([1], $query->getBindings());
    }

    public function testFindMultipleContextBuilderExtension()
    {
        $model = new EloquentMultipleRequiredBuilderExtensionModel();

        $this->assertTrue($model->hasBuilderExtension(ActiveBuilderExtension::class));
    }

    public function testFindLocalBuilderExtension()
    {
        $model = new EloquentSingleLocalBuilderExtensionModel();

        $this->assertTrue($model->hasBuilderExtension('active'));
        $this->assertFalse($model->hasBuilderExtension(ActiveBuilderExtension::class));
    }

    public function testRegularBuilderExtensionIsApplied()
    {
        $model = new EloquentSingleRegularBuilderExtensionModel;
        $query = $model->newQuery()->active();

        $this->assertSame('select * from "table" where "active" = ?', $query->toSql());
        $this->assertEquals([true], $query->getBindings());
    }

    public function testLocalBuilderExtensionIsApplied()
    {
        $model = new EloquentSingleLocalBuilderExtensionModel;
        $query = $model->newQuery()->active();

        $this->assertSame('select * from "table" where "active" = ?', $query->toSql());
        $this->assertEquals([true], $query->getBindings());
    }
}

/**
 * Test models
 */

#[BuilderExtension(ActiveBuilderExtension::class, BuilderExtensionType::REQUIRED)]
class EloquentSingleRequiredBuilderExtensionModel extends Model
{
    protected $table = 'table';
}

#[BuilderExtension(ActiveBuilderExtension::class, BuilderExtensionType::REQUIRED)]
#[BuilderExtension(OrderBuilderExtension::class, BuilderExtensionType::REQUIRED)]
class EloquentMultipleRequiredBuilderExtensionModel extends Model
{
    protected $table = 'table';
}

#[BuilderExtension(ActiveBuilderExtension::class)]
class EloquentSingleRegularBuilderExtensionModel extends Model
{
    protected $table = 'table';


}

#[BuilderExtension(ActiveBuilderExtension::class)]
#[BuilderExtension(OrderBuilderExtension::class)]
class EloquentMultipleRegularBuilderExtensionModel extends Model
{
    protected $table = 'table';
}

#[BuilderExtension(ActiveBuilderExtension::class, BuilderExtensionType::REQUIRED)]
#[BuilderExtension(OrderBuilderExtension::class)]
class EloquentSingleRequiredAndRegularBuilderExtensionModel extends Model
{
    protected $table = 'table';
}

class EloquentSingleLocalBuilderExtensionModel extends Model
{
    protected $table = 'table';

    #[BuilderExtension]
    public function active(Builder &$builder)
    {
        $builder->where('active', true);
    }
}

class EloquentMultipleLocalBuilderExtensionModel extends Model
{
    protected $table = 'table';

    #[BuilderExtension]
    public function active(Builder &$builder)
    {
        $builder->where('active', true);
    }

    #[BuilderExtension]
    public function sorted(Builder &$builder)
    {
        $builder->orderBy('name');
    }
}

class EloquentBadLocalBuilderExtensionModel extends Model
{
    protected $table = 'table';

    #[BuilderExtension(OrderBuilderExtension::class)]
    #[BuilderExtension(ActiveBuilderExtension::class)]
    public function active($query)
    {
        $query->where('active', true);
    }
}



class ActiveBuilderExtension implements BulderExtensionInterface
{
    public function apply(Builder &$builder)
    {
        $builder->where('active', 1);
    }
}

class OrderBuilderExtension implements BulderExtensionInterface
{
    public function apply(Builder &$builder)
    {
        $builder->orderBy('name');
    }
}