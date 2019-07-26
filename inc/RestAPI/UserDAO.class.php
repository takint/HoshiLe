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

    //Create a User
    static function createUser(User $user): int {

        $sql = 'INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':name', $user->getName());
        self::$db->bind(':email', $user->getEmail());
        self::$db->bind(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT));

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->lastInsertedId();
    }

    //Update a User
    static function updateUser(User $user): bool {

        $sql = 'UPDATE Users SET name = :name, email = :email WHERE id = :id';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $user->getId());
        self::$db->bind(':name', $user->getName());
        self::$db->bind(':email', $user->getEmail());

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->rowCount() > 0;
    }
}

?>