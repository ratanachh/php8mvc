<?php
declare(strict_types=1);

namespace QuickSoft;

use QuickSoft\File\Directory;

class Application
{
    protected string $filename;
    public Request $request;
    

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->init();
    }
    
    public function run() : string
    {
        return $this->request->getResponse()->getContent();
    }

    private function init() : void
    {
        $this->loadConfig();
        $this->request = new Request($this);
    }
    
    public function loadConfig(): void
    {
        
    }

    public function getFileName(): string
    {
        return $this->filename;
    }
}