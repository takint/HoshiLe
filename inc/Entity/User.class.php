<?php

// +--------------+--------------+------+-----+---------+----------------+
// | Field        | Type         | Null | Key | Default | Extra          |
// +--------------+--------------+------+-----+---------+----------------+
// | id           | int(11)      | NO   | PRI | NULL    | auto_increment |
// | name         | varchar(255) | NO   |     | NULL    |                |
// | email        | varchar(255) | NO   |     | NULL    |                |
// | password     | varchar(255) | NO   |     | NULL    |                |
// | shoppingCart | text         | YES  |     | NULL    |                |
// +--------------+--------------+------+-----+---------+----------------+

class User extends BaseEntity {

    private $name;
    private $email;
    private $password;
    private $shoppingCart;

    // Getter
    public function getName() : string {
        return $this->name;
    }

    public function getEmail() : string{
        return $this->email;
    }

    public function getPassword() : string{
        return $this->password;
    }

    public function getShoppingCart() : ?string{
        return $this->shoppingCart;
    }

    // Setter
    public function setName(string $value) {
        $this->name = $value;
    }

    public function setEmail(string $value) {
        $this->email = $value;
    }

    public function setPassword(string $value) {
        $this->password = $value;
    }

    public function setShoppingCart(?string $value) {
        $this->shoppingCart = $value;
    }

    public function serialize(bool $includePassword = false) : stdClass {
        $obj = new stdClass;
        
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->email = $this->email;
        if ($includePassword) {
            $obj->password = $this->password;
        }
        $obj->shoppingCart = $this->shoppingCart;

        return $obj;
    }

    public static function deserialize(stdClass $obj, bool $includePassword = false) : User {
        $user = new User();

        $user->setId($obj->id);
        $user->setName($obj->name);
        $user->setEmail($obj->email);
        if ($includePassword) {
            $user->setPassword($obj->password);
        }
        $user->getShoppingCart($obj->shoppingCart);

        return $user;
    }
}

?>