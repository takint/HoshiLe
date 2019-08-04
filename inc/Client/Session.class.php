<?php

class Session {

    public static $userId = null;
    public static $userName = null;
    public static $isAdmin = false;

    public static function initialize() {
        session_start();

        if (!empty($_SESSION['user'])) {
            self::$userId = $_SESSION['user']['id'];
            self::$userName = $_SESSION['user']['name'];
            self::$isAdmin = $_SESSION['user']['admin'];
        }
    }

    public static function setUser(int $id, string $name, bool $admin = false) {
        self::$userId = $id;
        self::$userName = $name;
        self::$isAdmin = $admin;
        $_SESSION['user'] = array(
            'id' => self::$userId,
            'name' => self::$userName,
            'admin' => self::$isAdmin
        );
    }

    public static function login(string $email, string $password): ?string {
        if ($email == '' || $password == '') {
            return 'Oops, your email or password is empty.';
        }

        $params = array(
            'email' => $email,
            'password' => $password
        );
        $result = RestClient::call('GET', USER_API, $params);
        if ($result) {
            $user = User::deserialize($result);
            self::setUser($user->getId(), $user->getName(), $user->getIsAdmin());
            ShoppingCart::mergeShoppingCart(json_decode($user->getShoppingCart()));
            return null;
        } else {
            return 'Oops, your email or password is incorrect.';
        }
    }

    public static function signup(string $name, string $email, string $password1, string $password2): ?string {
        if ($name == '' || $email == '' || $password1 == '') {
            return 'Oops, your name, email, or password is empty.';
        }
        if ($password1 != $password2) {
            return 'Oops, your passwords do not match.';
        }

        $params = array(
            'name' => $name,
            'email' => $email,
            'password' => $password1
        );
        $result = RestClient::call('POST', USER_API, $params);
        if ($result) {
            self::setUser($result, $name);
            ShoppingCart::mergeShoppingCart();
            return null;
        } else {
            return 'Sorry, failed to create a user.';
        }
    }

    public static function updateProfile(string $name, string $email): ?string {
        if (is_null(self::$userId)) {
            return 'Oops, you are not logged in';
        }
        if ($name == '' || $email == '') {
            return 'Oops, your name or email is empty.';
        }

        $params = array(
            'id' => self::$userId,
            'name' => $name,
            'email' => $email
        );
        $result = RestClient::call('PUT', USER_API, $params);
        if ($result) {
            self::setUser(self::$userId, $name);
            return null;
        } else {
            return 'Sorry, failed to update a user.';
        }
    }

    public static function updatePassword(string $curPassword, string $password1, string $password2): ?string {
        if (is_null(self::$userId)) {
            return 'Oops, you are not logged in';
        }
        if ($curPassword == '' || $password1 == '') {
            return 'Oops, your password is empty.';
        }
        if ($password1 != $password2) {
            return 'Oops, your passwords do not match.';
        }

        $params = array(
            'id' => self::$userId,
            'curPassword' => $curPassword,
            'newPassword' => $password1
        );
        $result = RestClient::call('PUT', USER_API, $params);
        if ($result) {
            return null;
        } else {
            return 'Sorry, failed to update password.';
        }
    }

    public static function logout() {
        self::$userId = null;
        self::$userName = null;
        self::$isAdmin = false;
        unset($_SESSION['user']);

        ShoppingCart::clearShoppingCart();
    }
}

?>