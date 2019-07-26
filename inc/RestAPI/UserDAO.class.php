<?php

class UserDAO {

    private static $db;

    static function initialize() {
        //Initialize the database connection
        self::$db = new PDOAgent('User');
    }

    //READ a single User
    static function getUser(int $id): ?User {

        $sql = 'SELECT * FROM Users WHERE id = :id';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $id);

        // Execute
        self::$db->execute();

        // Return the result
        $result = self::$db->singleResult();
        return $result ? $result : null;
    }

    //Authenticate a User
    static function authUser(string $email, string $password): ?User {

        $sql = 'SELECT * FROM Users WHERE email = :email';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':email', $email);

        // Execute
        self::$db->execute();

        // Return the result
        $result = self::$db->singleResult();
        if ($result && password_verify($password, $result->getPassword())) {
            return $result;
        } else {
            return null;
        }
    }
}

?>