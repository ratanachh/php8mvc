<?php
declare(strict_types=1);

namespace QuickSoft\Controllers;

use QuickSoft\Controller as ControllerBase;
use QuickSoft\Route;
use QuickSoft\HttpMethod\{
    HttpGet
};

#[Route('/home')]
class HomeController extends ControllerBase
{
    #[HttpGet]
    public function index()
    {
        
    }
}