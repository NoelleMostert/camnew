<?php
require_once 'core/init.php';

if (isset($_GET["token"]))
{
    $plain = base64_decode($_GET["token"]);
    $split_token =  preg_split('/delimitstring/',$plain);

    $username = $split_token[0];
    $token = $split_token[1];

    $dbo =  DB::getInstance();

    $arr_wheres = array("username", "=", $username);

    $res = $dbo->get('users', $arr_wheres);
    $info = (array) $res->results()[0];
    var_dump($info["activation_key"]);
    if ($dbo->count() == 1 && $info["activation_key"] === $token)
    {
         $sql = "UPDATE `users` SET `verified` = '1' WHERE `users`.`username` =:uname";
         $params = array (0 => $username);
         $dbo->query($sql, $params);
         Session::flash('home', 'You have been verified successfully. Please log in now');
         Redirect::to('index.php');
    }
    else
    {
        Session::flash('home', 'Error with your verification link. Please try copy your link again');
        Redirect::to('index.php');
    }
}
?>