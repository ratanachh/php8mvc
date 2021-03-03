<?php

namespace QuickSoft;

#[\Attribute]
class Route
{
    
    public function __construct(string $pattern, string|array $methods = ['GET'])
    {
    }
}