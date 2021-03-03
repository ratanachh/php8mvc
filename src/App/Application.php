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
        $dir = new Directory($this->filename);
        $this->request = new Request($this, $dir->getAbsoluteUri());
    }
    
    public function loadConfig(): void
    {
        
    }
}