<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;
use \Hotel\Review;

$user = new User();
//return to home page if not a post request 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /project/public/login.php');

    return;
}

//if there is already logged in user, return to main page  
if (empty(User::getCurrentUserId())) {
    header('Location: /project/public/login.php');
 
    return;
}

//Check if room id  is given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
    header('Location: /project/public/login.php');

    return;
} 

//Add Review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
//Return to home page 
header("Location: /project/public/room-page.php?room_id={$roomId}&check_in_date={$checkInDate}&check_out_date={$checkOutDate}");
exit;
