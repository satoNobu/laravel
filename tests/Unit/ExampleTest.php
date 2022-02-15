<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
        $this->assertTrue(true);
    }

    public function test_hoge()
    {
        $this->assertTrue(true);
    }

    // 認識されない
    public function example()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * 日本語でもOK
     */
    public function テスト()
    {
        $this->assertTrue(true);
    }

}
