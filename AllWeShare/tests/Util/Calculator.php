<?php

namespace App\Util;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    protected $calculator;

    protected function setUp()
    {
        $this->calculator = new Calcul();
    }

    public function testAdd()
    {
        $result = $this->calculator->add(30, 12);

        $this->assertEquals(42, $result);
    }

    public function testSub()
    {
        $result = $this->calculator->sub(30, 12);

        $this->assertEquals(18, $result);
    }

    public function testMul()
    {
        $result = $this->calculator->mul(6, 3);

        $this->assertEquals(18, $result);
    }

    public function testDivHappyFlow()
    {
        $result = $this->calculator->div(36, 2);

        $this->assertEquals(18, $result);
    }

    public function testDivWith0()
    {
        $result = $this->calculator->div(36, 0);

        $this->assertEquals('lel t con', $result);
    }

    public function testAvg()
    {
        $result = $this->calculator->avg(18, 18);

        $this->assertEquals(18, $result);
    }
}