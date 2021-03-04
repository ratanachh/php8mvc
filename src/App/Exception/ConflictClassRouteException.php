<?php

namespace QuickSoft\Exception;


class ConflictClassRouteException extends \ErrorException
{
    public function __construct($message, $code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(409);
        parent::__construct("The route of controller can not be the same: $message", $code, $severity, $filename, $line, $previous);
    }
}