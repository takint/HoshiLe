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

    // Getter
    public function getUserId() : string {
        return $this->userId;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    // Setter
    public function setUserId(string $value) {
        $this->userId = $value;
    }

    public function setCreateDate($value) {
        $this->createDate = $value;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        
        $obj->id = $this->id;
        $obj->userId = $this->userId;
        $obj->createDate = $this->createDate;

        return $obj;
    }
}

?>