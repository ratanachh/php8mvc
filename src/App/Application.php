<?php
declare(strict_types=1);

namespace QuickSoft;

use QuickSoft\File\Directory;

class Application
{
    protected string $filename;
    public Request $request;
    
    public static Application $app;

    public function __construct(string $filename)
    {
        self::$app = $this;
        $this->filename = $filename;
        $this->init();
    }
    
    public function run() : string
    {
        return $this->request->getResponse()->getContent();
    }

    private function init() : void
    {
        $dir = new Directory($this->filename);
        $this->request = new Request($dir->getAbsoluteUri());
    }
    
    public function loadConfig(): void
    {
        
    }
}