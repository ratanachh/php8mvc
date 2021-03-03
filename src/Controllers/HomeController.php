<?php
declare(strict_types=1);

namespace QuickSoft\Controllers;

use QuickSoft\Controller as ControllerBase;
use QuickSoft\Route;


class HomeController extends ControllerBase
{
    #[Route('/home')]
    public function index()
    {
        
    }
}