<?php

abstract class BaseEntity {
    protected $id;

    public function getId() : int {
        return $this->id;
    }

    public function setId(int $value) {
        $this->id = $value;
    }

    public function serialize() : stdClass {
        $obj = new stdClass;
        $obj->id = $this->id;

        return $obj;
    }
}

?>