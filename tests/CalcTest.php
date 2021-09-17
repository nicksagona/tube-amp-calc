<?php

namespace Calc\Test;

use PHPUnit\Framework\TestCase;

class CalcTest extends TestCase
{

    public function testConstructor()
    {
        $calc = new \Calc\Module();
        $this->assertInstanceOf('Calc\Module', $calc);
    }

}