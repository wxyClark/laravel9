<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * 创建单元测试 php artisan make:test ColumnTest --unit
 */
class ColumnTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $array = [];
        $a = empty($array['key']);
        $this->assertTrue(!$a);
    }
}
