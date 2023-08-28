<?php
    require __DIR__.'/../boot/boot.php';

    use Hotel\Room;
    use Hotel\RoomType;

    //get cities 
    $room = new Room();
    $cities = $room->getCities();

    //Get room type
    $type = new RoomType();
    $allType = $type->getRoomType();
    // print_r($allType);die;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Αναζήτηση καταλυμάτων</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
    />
  </head>
  <body>
    <header>
        <div class="header-hotel">
            <p class="menu-logo" style="font-weight: 500;">Hotels</p>
        </div>
        <div class="menu-right">
            <a href="index.php"><i class="fa-sharp fa-solid fa-house"></i>Home </a>
            |
            <a href="profile.php"><i class="fa-solid fa-user"></i>Profile </a>
        </div>      
    </header>
    <main>
        <section class="hero">
            <form name="searchForm" action="list-hotel.php" method="GET">
                <div class="form-group sel">
                    <section class="city">
                        <select name="City">
                            <option value="">City</option>
                            <?php
                                foreach($cities as $city) {
                            ?>
                                <option value="<?php echo $city ?>"><?php echo $city ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </section>
                    <section class="roomtype">
                        <select name="typeRoom">
                            <option value="">Type Room</option>
                            <?php
                                foreach($allType as $roomType) {
                            ?>
                                <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </section>
                </div> 
                <div class="form-group check">
                    <section class="ch-in">
                        <input type="text" id="datepicker1" placeholder="Check in" name="check_in_date"/>
                    </section>
                    <section class="ch-out">
                        <input type="text" id="datepicker2" placeholder="Check out" name="check_out_date"/>
                    </section>
                </div>
                <div class="form-group">
                    <input id="form-submit" type="submit" value="Submit" name="submit">
                </div>
            </form>
        </section>
    </main>
    <footer><p>&copy; CollegeLink Hotel</p></footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="./assets/js/datepicker.js"></script>
    <script src="./assets/js/city-search.js"></script>
    <script src="./assets/js/typeRoom.js"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>
</html>