<?php

namespace TubeCalc\Test;

use PHPUnit\Framework\TestCase;

class TubeCalcTest extends TestCase
{

    public function testConstructor()
    {
        $calc = new \TubeCalc\Module();
        $this->assertInstanceOf('TubeCalc\Module', $calc);
    }

}