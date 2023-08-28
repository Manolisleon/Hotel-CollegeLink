<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;
use \Hotel\Booking;

$user = new User();

//return to home page if not a post request 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /project/public/index.php');

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
    header('Location: /project/public/index.php');

    return;
} 


//Create booking 
$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$booking->insert($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);

//Return to home page 
header("Location: /project/public/room-page.php?room_id={$roomId}&check_in_date={$checkInDate}&check_out_date={$checkOutDate}");
exit;