<?php
require_once 'Constant.php';

function dirToArray($path): array
{
    $result = [];
    $dir = scandir($path);
    foreach ($dir as $key => $value)
    {
        if (!in_array($value, ['.', '..']))
        {
            
//            if (is_dir($path . DIRECTORY_SEPARATOR . $value))
//            {
//                $result[$value] = dirToArray($path . DIRECTORY_SEPARATOR . $value);
//            }
//            else
//            {
//                $result[] = $value;
//            }
        }
    }

    return $result;
}