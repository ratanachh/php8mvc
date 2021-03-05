<?php
declare(strict_types=1);

namespace QuickSoft;

use QuickSoft\Config\Filter;
use QuickSoft\File\Directory;

class Application
{
    protected string $filename;
    public Request $request;
    public Response $response;
    public Dispatcher $dispatcher;
    public Filter $filter;


    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->init();
    }
    
    public function run() : string
    {
        $this->dispatcher->invoke();
        return $this->response->getContent();
    }

    private function init() : void
    {
        $this->loadConfig();
        $this->dispatcher = new Dispatcher($this);
        $this->response = new Response();
        $this->filter = new Filter($this);
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