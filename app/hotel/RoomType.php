<?php

namespace Hotel;

use Hotel\BaseServise;
use DateTime;
use PDO;

class RoomType extends BaseServise {

    public function getRoomType() {
        return $this->fetchAll('SELECT * FROM room_type');
    }

}

