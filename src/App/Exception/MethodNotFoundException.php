<?php

namespace QuickSoft\Exception;


class MethodNotFoundException extends \ErrorException
{
    public function __construct($code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(404);
        parent::__construct('Method Not Found.', $code, $severity, $filename, $line, $previous);
    }
}