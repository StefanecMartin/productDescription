<?php

class Country
{
    protected $id;
    protected $code;
    protected $shopsysCode;

    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getShopsysCode() {
        return $this->shopsysCode;
    }

    public function setShopsysCode($shopsysCode) {
        $this->shopsysCode = $shopsysCode;
    }

}