<?php
declare(strict_types=1);

namespace QuickSoft\HttpMethod;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::TARGET_FUNCTION)]
class HttpGet extends Http
{
    public function __construct(
        public string $route = ''
    ){}
}