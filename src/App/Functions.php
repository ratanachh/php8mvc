<?php
require_once 'Constant.php';

function each(&$arr) {
    $key = key($arr);
    $result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
    next($arr);
    return $result;
}

function trim_to_array(string $value, string $separator = '/') : array
{
    return array_values(array_diff(explode($separator, $value), ['']));
}