<?php

namespace Nova\Auth\Test;

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{

    public function testConstructor()
    {
        $auth = new \Nova\Auth\Module();
        $this->assertInstanceOf('Nova\Auth\Module', $auth);
    }

}