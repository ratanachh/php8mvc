<?php
declare(strict_types=1);

namespace QuickSoft;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Route
{
    public function __construct(
        private string $pattern = ''
    ){}

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}