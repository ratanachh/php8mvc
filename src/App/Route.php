<?php
declare(strict_types=1);
namespace QuickSoft;

#[\Attribute]
class Route
{
    public function __construct(
        private string $pattern = ''
    ){}

    public function getPattern()
    {
        return $this->pattern;
    }
}