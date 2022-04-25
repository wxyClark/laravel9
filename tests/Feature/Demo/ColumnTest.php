<?php

namespace Tests\Feature\Demo;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * 创建 feature 测试 php artisan make:test Demo/ColumnTest
 */
class ColumnTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_undefined_key()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
