<?php

namespace QuickSoft\Controllers\Admin;

use QuickSoft\Controller as ControllerBase;
use QuickSoft\HttpMethod\HttpGet;
use QuickSoft\Route;

#[Route("/homes")]
class DashboardController extends ControllerBase
{
    #[HttpGet('called')]
    public function index()
    {
        
    }
}