<?php
declare(strict_types=1);

namespace QuickSoft\HttpMethod;

#[\Attribute]
class HttpGet extends Http
{
    public function __construct(
        public string $route = '/'
    ){}
}