<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;

//return to home page if not a post request 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /project/public/index.php');

    return;
}

$user = new User();
try {
    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
        header('Location: /project/public/login.php?error=Could not verify user');

        return;
    }
} catch (InvalidArgumentException $ex) {
    header('Location: /project/public/login.php?error=No user exists with given email');

    return;
}

//Retrive User
$userInfo = $user->getByEmail($_REQUEST['email']);

//Generate Token
$token = $user->generateToken($userInfo['user_id']);

//set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

//Return to home page 
header('Location: /project/public/index.php');
