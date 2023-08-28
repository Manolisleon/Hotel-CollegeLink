<?php

namespace Hotel;

use PDO;
use Hotel\BaseServise;
use Support\Configuration\Configuration;
use DateTime;

class Room extends BaseServise {

    public function get($roomId) {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }

    public function getCities() {

        //get cities
        $cities = [];
        $rows = $this->fetchAll('SELECT DISTINCT city FROM room');

        foreach ($rows as $row) {
            $cities[] = $row['city'];
        }

        return $cities;
    }
    
    public function searchRoom($city, $type_id, $checkInDate, $checkOutDate) {

        //execute SQL
        $statement = $this->getPdo()->prepare('SELECT * FROM room WHERE city = :city AND type_id = :type_id AND room_id NOT IN (
            SELECT room_id 
            FROM `booking` 
            WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date 
        ) ORDER BY `city` ASC, `price` ASC');
        
        // Format check-in and check-out dates as strings
        $checkInDateTime = (new DateTime($checkInDate))->format('Y-m-d H:i:s');
        $checkOutDateTime = (new DateTime($checkOutDate))->format('Y-m-d H:i:s');
        
        //bind parameters
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':type_id', $type_id, PDO::PARAM_STR);
        $statement->bindParam(':check_in_date', $checkInDateTime, PDO::PARAM_STR);
        $statement->bindParam(':check_out_date', $checkOutDateTime, PDO::PARAM_STR);
    
        $statement->execute();
    
        //get rooms
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getCountOfGuests() {
        return $this->fetchAll('SELECT DISTINCT count_of_guests FROM `room`');
    }

}