<?php

namespace QuickSoft\Exception;


class InternalErrorException extends \ErrorException
{
    public function __construct($code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(503);
        parent::__construct('Internal Server error.', $code, $severity, $filename, $line, $previous);
    }
}