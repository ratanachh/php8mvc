<?php
declare(strict_types=1);

namespace QuickSoft\HttpMethod;

abstract class Http
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    public function getRoutePath()
    {
        return $this->route;
    }
}