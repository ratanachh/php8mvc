<?php
declare(strict_types=1);

namespace QuickSoft\Controllers;

use QuickSoft\Controller as ControllerBase;
use QuickSoft\Route;
use QuickSoft\HttpMethod\{HttpDelete, HttpGet, HttpPut};

#[Route('/home')]
class HomeController extends ControllerBase
{
    #[HttpGet]
    public function index()
    {
        
    }

    #[HttpPut('/{id}')]
    public function index2()
    {

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