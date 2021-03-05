<?php
declare(strict_types=1);

namespace QuickSoft\Controllers;

use QuickSoft\Controller as ControllerBase;
use QuickSoft\Route;
use QuickSoft\HttpMethod\{HttpDelete, HttpGet, HttpPut};

#[Route('home')]
class HomeController extends ControllerBase
{
    #[HttpGet]
    public function index()
    {
        
    }

    #[HttpPut('/{id}/test/{value}')]
    public function index2($id, $value)
    {
        var_dump($id);
        var_dump($value);
        $this->response->setContent('hello');
    }

    #[HttpPut]
    public function index3()
    {

    }
    #[HttpDelete]
    public function index4()
    {

    }
}