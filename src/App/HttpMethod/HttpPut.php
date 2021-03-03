<?php
declare(strict_types=1);

namespace QuickSoft\HttpMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class HttpPut extends Http
{
    public function __construct(
        public string $route = '/'
    ){}
}