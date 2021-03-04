<?php

namespace QuickSoft\Exception;


class ControllerNotFoundException extends \ErrorException
{
    public function __construct($code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(404);
        parent::__construct("Controller not found.", $code, $severity, $filename, $line, $previous);
    }
}