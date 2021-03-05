<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CreateGuidV4Test extends TestCase
{
    public function testCreateGuidV4(): void
    {
        require_once '../src/App/Functions.php';
        $this->assertIsString(GUIDv4());
    }
}