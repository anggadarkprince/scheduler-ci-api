<?php

/**
 * Created by PhpStorm.
 * User: Angga
 * Date: 10/12/2015
 * Time: 4:55 PM
 */
class Util
{
    public static function prettyPrint($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function encode($data)
    {
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}