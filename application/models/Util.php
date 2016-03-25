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
        header("Content-Type:application/json");
        echo json_encode($data);
    }
}