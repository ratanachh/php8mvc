<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    public function testSessionInstantiate(): void
    {
        $ses1 = \QuickSoft\Session::getInstance();
        $ses2 = \QuickSoft\Session::getInstance();
        var_dump($ses2);
        
        $this->assertEquals($ses1, $ses2);
    }
}