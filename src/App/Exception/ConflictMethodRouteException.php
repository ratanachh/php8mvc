<?php

namespace QuickSoft\Exception;


class ConflictMethodRouteException extends \ErrorException
{
    public function __construct($class = '', $method = '', $pattern = '', $code = 0, $severity = 1, $filename = __FILE__, $line = __LINE__, $previous = null)
    {
        http_response_code(409);
        parent::__construct("The route of method can not be the same. class: '$class', method: '$method', pattern: '$pattern'.", $code, $severity, $filename, $line, $previous);
    }
}