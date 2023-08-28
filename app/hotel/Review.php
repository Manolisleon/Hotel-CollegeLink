<?php

namespace Hotel;

use Hotel\BaseServise;

class Review extends BaseServise {

    public function getByUser($userId) {
        $parameters = [
            ':user_id' => $userId,
        ];

        return $this->fetchAll('SELECT review.*, room.name
         FROM review 
         INNER JOIN room ON review.room_id = room.room_id
         WHERE user_id = :user_id' , $parameters);
    }

    public function insert($roomId, $user_id, $rate, $comment) {
        //Start transaction
        $this->getPdo()->beginTransaction();

        //Insert Review
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $user_id,
            ':rate' => $rate,
            ':comment' => $comment,
        ];
        $this->execute('INSERT INTO review (room_id, user_id, rate, comment)
         VALUES (:room_id, :user_id, :rate, :comment)', $parameters);

        //Update avg rate
        $parameters = [
            ':room_id' => $roomId,
        ];
        $roomAverage = $this->fetch('SELECT avg(rate) as avg_reviews, count(*) as count FROM review WHERE room_id = :room_id', $parameters);
        $parameters = [
            ':room_id' => $roomId,
            ':avg_reviews' => $roomAverage['avg_reviews'],
            ':count_reviews' => $roomAverage['count'],
        ];
        $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count_reviews WHERE room_id = :room_id', $parameters);

        //Commit transaction
        return $this->getPdo()->commit();
    
    }

    public function getReviewByRoom($roomId) {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetchAll('SELECT review.*, user.name as user_name 
            FROM review 
            INNER JOIN user ON review.user_id = user.user_id 
            WHERE room_id = :room_id', $parameters);

    }
}