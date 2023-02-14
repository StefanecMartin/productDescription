<?php

class Technology
{
    protected $name;
    protected $description;
    protected $url;

    public function Technology($name, $description, $url) {
        $this->$name = $name;
        $this->$description = $description;
        $this->$url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
    $this->url = $url;
}

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
    $this->name = $name;
}

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
    $this->description = $description;
}
}