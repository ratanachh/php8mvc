<?php

namespace QuickSoft\Exception;


class NotFoundException extends \ErrorException
{
    public function __construct($message = "", $code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(404);
        parent::__construct($message, $code, $severity, $filename, $line, $previous);
    }
}