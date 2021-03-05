<?php
declare(strict_types=1);

namespace QuickSoft\Config;

use QuickSoft\Request;
use QuickSoft\Response;

interface FilterInterface
{
    function before(Request $request);
    function after(Request $request, Response $response);
}