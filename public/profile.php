<?php

    require __DIR__.'/../boot/boot.php';

    use Hotel\Favorite;
    use Hotel\Review;
    use Hotel\Booking;
    use Hotel\User;

    //if there is already logged in user, return to main page  
    $userId = User::getCurrentUserId();
    if (empty($userId)) {
        header('Location: /project/public/login.php');
    
        return;
    }

    $user = new User();
    $userInfo = $user->getById($userId);

    //favorite rooms
    $favorite = new Favorite();
    $userFavorite = $favorite->getByUser($userId);

    //review rooms
    $review = new Review();
    $userReview = $review->getByUser($userId);

    //user bookings
    $booking = new Booking();
    $userBooking = $booking->getByUser($userId);
    // print_r($userBooking);die;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>My profile</title>
    <link rel="stylesheet" href="./assets/css/profile-style.css">
  </head>
  <body>
    <header>
        <div class="header-hotel">
            <p class="menu-logo" style="font-weight: 500;">Hotels</p>
        </div>
        <div class="menu-right">
            <ul>
                <li><a href="./index.php"><i class="fa-sharp fa-solid fa-house"></i>Home </a></li>
                <li>|</li>
                <li><a href="./profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
            </ul>
        </div>      
    </header>
    <main class="container">
        <aside class="asbar">
            <div class="user">
                <h2><?php echo $userInfo['name'] ?></h2>
                <img src="./assets/images/user.jpg" width="100px" />
                <h3 style="color: #757575"><?php echo $userInfo['email'] ?></h3>
                <button class="logout" style="border: none; background-color: #757575; margin-left: auto; margin-right: auto;">Αποσύνδεση</button>
            </div>
            <h2>FAVORITES</h2>
            <?php
            if (count($userFavorite) > 0) {
            ?>
            <ol>
                <?php
                foreach ($userFavorite as $favorite) {
                ?>
                <li><a style="color: #000;" href="./room-page.php?room_id=<?php echo $favorite['room_id'] ?>"><?php echo $favorite['name'] ?></a></li>
                <?php
                }
                ?>
            </ol>
            <?php
            } else {
            ?>
            <p style="color: red; text-align: center;">There is not favorite yet!</p>
            <?php
            }
            ?>
            <h2>REVIEWS</h2>
            <?php
            if (count($userReview) > 0) {
            ?>
            <ol>
                <?php
                foreach ($userReview as $review) {
                ?>
                <li><a style="color: #000;" href="./room-page.php?room_id=<?php echo $review['room_id'] ?>"><?php echo $review['name'] ?></a>
                    <p style="margin-top: 0;">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($review['rate'] >= $i) {
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
                    </p>
                </li>
                <?php
                }
                ?>
            </ol>
            <?php
            } else {
            ?>
            <p style="color: red; text-align: center;">There is not reviews yet!</p>
            <?php
            }
            ?>
        </aside>
        <section class="list-hotel">
            <header class="hotel-bar">
                <h1>My Bookings</h1>
            </header>
            <?php
            if (count($userBooking) > 0) {
            ?>
            <article class="hotel">
                <?php
                foreach ($userBooking as $booking) {
                ?>
                <aside class="media">
                    <img src="assets/images/rooms/<?php echo $booking['photo_url'] ?>" width="100%" height="auto" > 
                </aside>
                <main class="info">
                    <h1><?php echo $booking['name'] ?></h1>
                    <h2 style="color: #444;"><?php echo $booking['address'] ?></h2>
                    <p><?php echo $booking['description_short'] ?></p>
                    <div class="hotel-submit text_right">
                        <button><a href="./room-page.php?room_id=<?php echo $booking['room_id'] ?>">Go to Room Page</a></button>
                    </div>
                </main>
                <div class="clear"></div>
                <section style="margin-bottom: 20px;" class="info-down">
                    <div class="info-price">
                        <p>Total cost: <?php echo $booking['total_price'] ?>€</p>
                    </div>
                    <div class="sum-guests">
                        <p>Check in date: <?php echo $booking['check_in_date'] ?></p>
                    </div>
                    <div class="break">
                        <p>|</p>
                    </div>
                    <div class="type-room">
                        <p>Check out date: <?php echo $booking['check_out_date'] ?></p>
                    </div>
                    <div class="break">
                        <p>|</p>
                    </div>
                    <div class="type-room">
                        <p>Room Type: <?php echo $booking['room_type'] ?></p>
                    </div>
                </section> 
                <?php
                }
                ?>
            </article>
            <?php
            } else {
            ?>
            <p style="color: red; text-align: center;">There is not reviews yet!</p>
            <?php
            }
            ?>
        </section> 
    </main>
    <footer><p>&copy; CollegeLink Hotel</p></footer>
    <link rel="stylesheet" href="assets/css/sliderbar.css" />
    <script src="./assets/js/logout.js"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>
</html>