<?php

namespace Tests\Unit;

use App\Models\Concerns\GeneratesTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use PHPUnit\Framework\TestCase;

class FindBySlugOrIdScopeTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_where_slug_or_id_scope_always_returns_builder_not_null(): void
    {
        $model = new class extends Model
        {
            use GeneratesTranslatableSlug;

            protected $table = 'projects';
        };

        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('whereKey')->once()->with(12)->andReturnSelf();

        $result = $model->newInstance()->scopeWhereSlugOrId($query, 12);

        $this->assertSame($query, $result);
    }
}
