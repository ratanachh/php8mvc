<?php
declare(strict_types=1);

namespace QuickSoft;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Route
{
    public function __construct(
        private string $pattern = '/'
    ){}

    /**
     * @return string
     */
    public function getPattern(): string
    {
        if (!str_starts_with($this->pattern, '/'))
            $this->pattern = '/' . $this->pattern;
        return $this->pattern; 
    }
}