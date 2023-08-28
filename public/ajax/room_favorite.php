<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;
use \Hotel\Favorite;

$user = new User();

//return to home page if not a post request 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    die;
} 

//if there is already logged in user, return to main page  
if (empty(User::getCurrentUserId())) {
    die;
}
//Check if room id  is given
$roomId = $_REQUEST['room_id'];
if(empty($roomId)) {
    die;
} 

//set room to favorite 
$favorite = new Favorite();
$isFavorite = $_REQUEST['is_favorite'];
if ($isFavorite == 0) {
    $status = $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
    $status = $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

//Return operation status 
header('Content-Type: application/json');
echo json_encode([
    'status' => $status,
    'is_favorite' => !$isFavorite,
]); 
