<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;
use \Hotel\Favorite;

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

//set room to favorite 
$favorite = new Favorite();
$isFavorite = $_REQUEST['is_favorite'];
if ($isFavorite == 0) {
    $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
    $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
//Return to home page 
header("Location: /project/public/room-page.php?room_id={$roomId}&check_in_date={$checkInDate}&check_out_date={$checkOutDate}");
exit;