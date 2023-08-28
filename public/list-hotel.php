<?php
    require __DIR__.'/../boot/boot.php';

    use Hotel\Room;
    use Hotel\RoomType;

    //inisialize Room service 
    $room = new Room();

    //get cities 
    $cities = $room->getCities();

    //Get room type
    $type = new RoomType();
    $allType = $type->getRoomType();

    //Get page parameters
    $city = $_REQUEST['City'];
    $typeRoom = $_REQUEST['typeRoom'];
    $checkInDate = $_REQUEST['check_in_date'];
    $checkOutDate = $_REQUEST['check_out_date'];

    $selectedCity = $_REQUEST['City'];
    $selectedTypeRoom = $_REQUEST['typeRoom'];

    //search for rooms 
    $allAvailiableRooms = $room->searchRoom($city, $typeRoom, $checkInDate, $checkOutDate);
    

    //get count of guests
    $countOfGuests = $room->getCountOfGuests();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Λίστα ξενοδοχείων</title>
    <link rel="stylesheet" href="./assets/css/list-style.css">
    <link
      rel="stylesheet"
      href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <header>
        <div class="header-hotel">
            <p class="menu-logo" style="font-weight: 500; margin: 0;">Hotels</p>
        </div>
        <div class="menu-right">
            <ul style="margin: 0;">
                <li><a href="./index.php"><i class="fa-sharp fa-solid fa-house"></i>Home </a></li>
                <li>|</li>
                <li><a href="./profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
            </ul>
        </div>      
    </header>
    <main class="container">
        <aside class="asbar">
            <div class="filters">
                <p>Hotel Filter <i class="fa-solid fa-arrow-down-wide-short"></i></p>
            </div>
            <form class="searchform" action="list-hotel.php" method="GET">
                <h1 class="form-header">Find the perfect hotel</h1>
                
                <div class="city">
                    <select name="City">
                        <option value="">City</option>
                        <?php
                            foreach($cities as $city) {
                        ?>
                            <option <?php echo $selectedCity == $city ? 'selected = "selected"' : '' ?> value="<?php echo $city ?>"><?php echo $city ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="roomtype">
                    <select name="typeRoom">
                        <option value="">Type Room</option>
                        <?php
                            foreach($allType as $roomType) {
                        ?>
                            <option <?php echo $selectedTypeRoom == $roomType['type_id'] ? 'selected = "selected"' : '' ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="price">
                    <input id="min-price" placeholder="0€" type="text">
                    <input id="max-price" placeholder="500€" type="text">
                    <div slider id="slider-distance">
                      <div>
                        <div inverse-left style="width:70%;"></div>
                        <div inverse-right style="width:70%;"></div>
                        <div range style="left:0%;right:0%;"></div>
                        <span thumb style="left:0%;"></span>
                        <span thumb style="left:100%;"></span>
                        <div sign style="left:0%;">
                          <span id="value">0</span>
                        </div>
                        <div sign style="left:100%;">
                          <span id="value">500</span>
                        </div>
                      </div>
                      <input id="value1" type="range" value="0" max="500" min="0" step="1" oninput="
                      this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
                      let value = (this.value/parseInt(this.max))*100
                      var children = this.parentNode.childNodes[1].childNodes;
                      children[1].style.width=value+'%';
                      children[5].style.left=value+'%';
                      children[7].style.left=value+'%';children[11].style.left=value+'%';
                      children[11].childNodes[1].innerHTML=this.value;" />

                      <input id="value2" type="range" value="500" max="500" min="0" step="1" oninput="
                      this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
                      let value = (this.value/parseInt(this.max))*100
                      var children = this.parentNode.childNodes[1].childNodes;
                      children[3].style.width=(100-value)+'%';
                      children[5].style.right=(100-value)+'%';
                      children[9].style.left=value+'%';children[13].style.left=value+'%';
                      children[13].childNodes[1].innerHTML=this.value;" />
                    </div>
                    <p class="min-price">Price Min</p>
                    <p class="max-price">Price Max</p>
                </div>
                <div class="chack-date">
                    <input type="text" id="datepicker1" placeholder="Check in" name="check_in_date" value="<?php echo $checkInDate ?>"/>
                    <input type="text" id="datepicker2" placeholder="Check out" name="check_out_date" value="<?php echo $checkOutDate ?>"/>
                </div>
                <div class="submit-form">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </aside>
        <section id="result-hotel" class="list-hotel">
            <header class="hotel-bar">
                <h1 style = "font-weight: 400;">Hotel result</h1>
            </header>
            <?php
                foreach($allAvailiableRooms as $AvailiableRoom) {
            ?>
            <article class="hotel">
                <aside class="media">
                    <img src="assets/images/rooms/<?php echo $AvailiableRoom['photo_url'] ?>" > 
                </aside>
                <main class="info">
                    <h1><?php echo $AvailiableRoom['name'] ?></h1>
                    <h2 style="color: #444;"><?php echo $AvailiableRoom['area'] ?> <?php echo $AvailiableRoom['address'] ?></h2>
                    <p><?php echo $AvailiableRoom['description_short'] ?></p>
                    <form class="hotel-submit text_right" method="GET" action="room-page.php">
                        <input type="hidden" name="room_id" value="<?php echo $AvailiableRoom['room_id'] ?>" />
                        <input type="hidden" name="check_in_date" value="<?php echo $checkInDate ?>" />
                        <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate ?>" />
                        <input type="submit" value="Go to Room Page"/>
                    </form>
                </main>
                <div class="clear"></div>
                <section class="info-down">
                    <div class="info-price">
                        <p>Per Night: <?php echo $AvailiableRoom['price'] ?></p>
                    </div>
                    <div class="sum-guests">
                        <p>Count of Guests: <?php echo $AvailiableRoom['count_of_guests'] ?></p>
                    </div>
                    <div class="break">
                        <p>|</p>
                    </div>
                    <div class="type-room">
                        <p>Type of Room: <?php foreach($allType as $roomType) {
                            if($roomType['type_id'] == $selectedTypeRoom) {
                                echo $roomType['title'];
                            }
                        } ?></p>
                    </div>
                </section> 
            </article>
            <?php
                }
            ?>
            <?php
                if (count($allAvailiableRooms) == 0) {
            ?> 
                <h3 style="color: #757575; font-size: 30px; font-weight: 500;">There are not availiable hotels.</h3>
            <?php
                }
            ?>
        </section> 
    </main>
    <footer><p style="margin-top: 6px;">&copy; CollegeLink Hotel</p></footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="./assets/js/datepicker.js"></script>
    <script src="./assets/js/list-hotel.js"></script>
    <script src="./assets/js/search.js"></script>
    <link rel="stylesheet" href="assets/css/sliderbar.css" />
    <script src="./assets/js/app.js"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>
</html>