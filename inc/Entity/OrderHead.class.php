<?php

// +------------+----------+------+-----+-------------------+----------------+
// | Field      | Type     | Null | Key | Default           | Extra          |
// +------------+----------+------+-----+-------------------+----------------+
// | id         | int(11)  | NO   | PRI | NULL              | auto_increment |
// | userId     | int(11)  | NO   |     | NULL              |                |
// | createDate | datetime | NO   |     | CURRENT_TIMESTAMP |                |
// +------------+----------+------+-----+-------------------+----------------+

class OrderHead extends BaseEntity {
    private $userId;
    private $createDate;

    private $user;
    private $details;

    // Getter
    public function getUserId() : string {
        return $this->userId;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function getUser() : User {
        return $this->user;
    }

    public function getDetails() : array {
        return $this->details;
    }

    // Setter
    public function setUserId(string $value) {
        $this->userId = $value;
    }

    public function setCreateDate($value) {
        $this->createDate = $value;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function setDetails(array $details) {
        $this->details = $details;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        
        $obj->id = $this->id;
        $obj->userId = $this->userId;
        $obj->createDate = $this->createDate;

        if (isset($this->user)) {
            $obj->user = $this->user->serialize();
        }
        if (isset($this->details)) {
            $obj->details = array_map(function($detail) { return $detail->serialize(); }, $this->details);
        }

        return $obj;
    }
}

?>