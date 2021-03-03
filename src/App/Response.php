<?php
declare(strict_types=1);

namespace QuickSoft;


class Response
{
    public string $content;
    
    public function __construct()
    {
        $this->content = '';
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    
    
    
}