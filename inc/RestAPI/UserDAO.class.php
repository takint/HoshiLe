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

    //READ a list of Users
    static function getUsers(array $ids = null): array {

        $sql = 'SELECT * FROM Users';
        if (!empty($ids)) {
            $sql .= ' WHERE id in (' . implode(', ', $ids) . ')';
        }

        // Query
        self::$db->query($sql);

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->getResultSet();
    }

    //READ a single User by email
    static function getUserByEmail(string $email): ?User {

        $sql = 'SELECT * FROM Users WHERE email = :email';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':email', $email);

        // Execute
        self::$db->execute();

        // Return the result
        $result = self::$db->singleResult();
        return $result ? $result : null;
    }

    //Create a User
    static function createUser(User $user): int {

        $sql = 'INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':name', $user->getName());
        self::$db->bind(':email', $user->getEmail());
        self::$db->bind(':password', $user->getPassword());

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

    //Update password
    static function updatePassword(User $user): bool {

        $sql = 'UPDATE Users SET password = :password WHERE id = :id';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $user->getId());
        self::$db->bind(':password', $user->getPassword());

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->rowCount() > 0;
    }

    //Update shopping cart
    static function updateShoppingCart(User $user): bool {

        $sql = 'UPDATE Users SET shoppingCart = :shoppingCart WHERE id = :id';

        // Query
        self::$db->query($sql);

        // Bind a parameter
        self::$db->bind(':id', $user->getId());
        self::$db->bind(':shoppingCart', $user->getShoppingCart());

        // Execute
        self::$db->execute();

        // Return the result
        return self::$db->rowCount() > 0;
    }
}

?>