<?php
    require __DIR__.'/../../boot/boot.php';

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

<section class="list-hotel">
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