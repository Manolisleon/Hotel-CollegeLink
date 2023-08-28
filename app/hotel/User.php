<?php

namespace Hotel;

use PDO;
use Hotel\BaseServise;
use Support\Configuration\Configuration;

class User extends BaseServise {
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';
    private static $currentUserId;

    public function getById($userId) {
      
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }

    public function getByEmail($email) {

        $parameters = [
            ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    public function getList() {

        return $this->fetchAll('SELECT * FROM user');
    }


    public function insert($name, $email, $password){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $statement = $this->getPdo()->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);

        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } 

    public function verify($email, $password) {
        //Retrive user
        $user = $this->getByEmail($email);

        //verify password
        return password_verify($password, $user['password']);
    }

    public function generateToken($userId)
    {

        // Create token payload
        $payload = [
            'user_id' => $userId,
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, SELF::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];

        // Generate signature and verify
        return $this->generateToken($userId) == $token;
    }

    public static function getCurrentUserId(){
        return self::$currentUserId;
    }

    public static function setCurrentUserId($userId) {
        self::$currentUserId = $userId;
    }

    public function loginUser($email, $password) {
        $statement = $this->getPdo()->prepare('SELECT * FROM user WHERE email = :email AND password = :password');

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();

        $statement->fetchAll(PDO::FETCH_ASSOC);

        return $statement;
    }
}