<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:47
 */
/**
 * @return bool|mysqli
 */
function connect()
{
    $db = @ mysqli_connect('localhost','root','remirexklds89','member_system');
    if(!$db) return false;
        mysqli_query($db,"SET NAMES UTF8");
    return $db;
}

/**
 * @param $data
 * @return string
 */
function test_input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}