<?php

require_once __DIR__.'/../../boot/boot.php';

use \Hotel\User;
use \Hotel\Review;

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

//Add Review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

//load user 
$userInfo = $user->getById(User::getCurrentUserId());
?>

<li><?php echo $userInfo['name'] ?>
<?php 
    for ($i = 1; $i <= 5; $i++) {
        if ($_REQUEST['rate'] >= $i) {
            ?>
            <i class="fa-solid fa-star yellow"></i>
            <?php
        } else {
            ?>
            <i class="fa-solid fa-star white"></i>
            <?php
        }
    }
    ?>
    <p class="styleP">Create at: <?php echo (new DateTime())->format('y-m-d H:i:s'); ?></p>
    <p class="styleP">
        <br>
        <strong><?php echo $_REQUEST['comment'] ?></strong>
        <br />
        <br />
    </p>
</li>