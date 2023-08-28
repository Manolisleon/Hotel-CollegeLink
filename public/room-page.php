<?php
    require __DIR__.'/../boot/boot.php';

    header('Access-Control-Allow-Origin: https://www.collegelink.gr');
    
    use Hotel\Room;
    use Hotel\Favorite;
    use Hotel\User;
    use Hotel\Review;
    use Hotel\Booking;
    
    $room = new Room();
    $favorite = new Favorite();

    //Check room_id
    $roomId = $_REQUEST['room_id'];
    if (empty($roomId)) {
        header('Location: index.php');
        die;
    }

    //Load room info
    $roomInfo = $room->get($roomId);
    if (empty($roomInfo)) {
        header('Location: index.php');
        die;
    } 

    //get current user_id
    $userId = User::getCurrentUserId();

    //Check if room is favorite for current user 
    $isFavorite = $favorite->isFavorite($roomId, $userId);

    //Load all review
    $review = new Review();
    $allReviews = $review->getReviewByRoom($roomId);

    //Check if already booked
    $checkInDate = $_REQUEST['check_in_date'];
    $checkOutDate = $_REQUEST['check_out_date'];
    // $alreadyBooked = empty($checkInDate) || empty($checkOutDate);

    $booking = new Booking();
    $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Room Page</title>
    <link rel="stylesheet" href="./assets/css/roompage-style.css">
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
        <div class="hotel-discriptions">
            <h2 style="display: inline;"><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> 
            | Reviews:
                <p style="display: inline;">
                <?php
                    $RoomAvgReviews = $roomInfo['avg_reviews'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($RoomAvgReviews >= $i) {
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
                    | 
                </p>
                <form id="favorite" style="display: inline;" method="POST" action="actions/favorite.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                    <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>" />
                    <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>" />
                    <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">

                    <button style="border-style: none; background-color: #fff; font-size: 20px;" type="submit"><i id="heart" class="fa-solid fa-heart <?php echo $isFavorite ? 'red' : 'white'; ?>"></i></button>
                </form>
            </h2>
            <p class="per-night">Per Night: <?php echo $roomInfo['price']; ?>€</p>
        </div>
        <div class="gallery-room">
            <img src="assets/images/rooms/<?php echo $roomInfo['photo_url'] ?>" > 
        </div>
        <div class="info-down">
            <section class="guests" style="border-right: 1px dashed #757575; margin: 4px;">
                <p><i class="fa-solid fa-user"></i><?php echo $roomInfo['count_of_guests'] ?></p>
                <p> COUNT OF GUESTS</p>
            </section>
            <section class="typeRoom" style="border-right: 1px dashed #757575; margin: 4px;">
                <p><i class="fa-solid fa-bed"></i><?php echo $roomInfo['type_id'] ?></p>
                <p>TYPE OF ROOM</p>
            </section>
            <section class="parking" style="border-right: 1px dashed #757575; margin: 4px;">
                <p><i class="fa-solid fa-square-parking"></i><?php echo $roomInfo['parking'] ? 'Yes' : 'No' ?></p>
                <p>PARKING</p>
            </section>
            <section class="wifi" style="border-right: 1px dashed #757575; margin: 4px;">
                <p><i class="fa-solid fa-wifi"></i><?php echo $roomInfo['wifi'] ? 'Yes' : 'No' ?></p>
                <p>WIFI</p>
            </section>
            <section class="pet" style="margin: 4px;">
                <p><i class="fa-solid fa-dog"></i><?php echo $roomInfo['pet_friendly'] ? 'Yes' : 'No' ?></p>
                <p>PET FRIENDLY</p>
            </section>
        </div>
        <div class="description">
            <h3 class="marginleft">Room Description</h3>
            <p class="marginleft"><?php echo $roomInfo['description_short'] ?></p>
        </div>
        <?php
            if ($alreadyBooked == 1) {
        ?>
        <div class="btn">
            <span style="background-color: #757575; color: #fff; padding: 4px;">Already Booked</span>
        </div>
        <?php
            } else {
        ?>
        <form method="POST" action="actions/book.php">
            <input type="hidden" name="room_id" value="<?php echo $roomId; ?>" />
            <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>" />
            <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>" />
            <div class="btn">
                <button type="submit">Book Now</button>
            </div>
        </form>
        <?php
            } 
        ?>
        <div class="google-map">
            <div id="map">
                <input type="hidden" id="lat" value="<?php echo $roomInfo['location_lat'] ?>" />
                <input type="hidden" id="lng" value="<?php echo $roomInfo['location_long'] ?>" />
            </div>
        </div>
        <div class="reviews">
            <h2 class="marginleft" style="margin-top: 0;">Recently Reviews</h2>
            <ol id="listOfReview" class="review-list" style="margin-bottom: 0;">
                <?php
                    foreach($allReviews as $review) {
                ?>
                <li><?php echo $review['user_name'] ?>
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
                    <p class="styleP">Create at: <?php echo $review['created_time'] ?></p>
                    <p class="styleP">
                        <br>
                        <strong><?php echo htmlentities($review['comment']); ?></strong>
                        <br />
                        <br />
                    </p>
                </li>
                <?php
                    }
                ?>
            </ol>
        </div>
        <div class="addReview">
            <form class="formReview" action="actions/review.php" method="POST">
                <h2 class="marginleft" style="margin-top: 0;">Add a Review</h2>
                <p class="marginleft inputs">
                    <br>
                    <i id="star1" class="rating__star far fa-star"></i>
                    <i id="star2" class="rating__star far fa-star"></i>
                    <i id="star3" class="rating__star far fa-star"></i>
                    <i id="star4" class="rating__star far fa-star"></i>
                    <i id="star5" class="rating__star far fa-star"></i>
                </p>
                <input type="hidden" name="room_id" value="<?php echo $roomId ?>"/>
                <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>" />
                <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>" />
                <input type="hidden" name="rate" value="" class="rate"/>
                <textarea name="comment" id="review" cols="50" rows="2" class="marginleft"></textarea>
                <input id="submit" type="submit" value="Submit" style="border: none;
                background-color: #757575;
                padding: 8px;
                border-radius: 5px;
                float: right;
                color: #ccc;">
            </form>
        </div>
    </main>
    <script
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
              defer
            ></script>
    <footer><p>&copy; CollegeLink Hotel</p></footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/ReviewEvent.js"></script>
    <script src="./assets/js/room.js"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>