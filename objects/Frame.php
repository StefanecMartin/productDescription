<?php

class Frame
{
    protected $frameColorId;
    protected $manufacturerFrameColorId;
    protected $frameColor;
    protected $manufactureFrameColor;

    /*public function __construct($frameColorId, $manufacturerFrameColorId, $frameColor, $manufactureFrameColor) {
        $this->frameColorId = $frameColorId;
        $this->manufacturerFrameColorId = $manufacturerFrameColorId;
        $this->frameColor = $frameColor;
        $this->manufactureFrameColor = $manufactureFrameColor;

    }*/

    public function __construct() {

    }

    public function getFrameColorId() {
        return $this->frameColorId;
    }

    public function setFrameColorId($frameColorId) {
        $this->frameColorId = $frameColorId;
    }

    public function getManufacturerFrameColorId() {
        return $this->manufacturerFrameColorId;
    }

    public function setManufacturerFrameColorId($manufacturerFrameColorId) {
        $this->manufacturerFrameColorId = $manufacturerFrameColorId;
    }

    public function getFrameColor() {
        return $this->frameColor;
    }

    public function setFrameColor($frameColor) {
        $this->frameColor = $frameColor;
    }

    public function getManufactureFrameColor() {
        return $this->manufactureFrameColor;
    }

    public function setManufactureFrameColor($manufactureFrameColor) {
        $this->manufactureFrameColor = $manufactureFrameColor;
    }
}