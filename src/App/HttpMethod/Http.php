<?php
declare(strict_types=1);

namespace QuickSoft\HttpMethod;

abstract class Http
{
    public function getRoutePath()
    {
        return $this->route;
    }
}