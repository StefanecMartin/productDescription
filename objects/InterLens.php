<?php

class InterLens
{
    protected $manufacturerLensColor;
    protected $lensColor;
    protected $vlt;
    protected $conditions;
    protected $category;
    protected $pictureUrl;
    protected $lensColorUrl;
    protected $conditionString;

    /*public function __construct($manufacturerLensColor, $lensColor, $vlt, $conditions, $category, $pictureUrl, $lensColorUrl, $conditionString)
    {
        $this->manufacturerLensColor = $manufacturerLensColor;
        $this->lensColor = $lensColor;
        $this->vlt = $vlt;
        $this->conditions = $conditions;
        $this->category = $category;
        $this->pictureUrl = $pictureUrl;
        $this->lensColorUrl = $lensColorUrl;
        $this->conditionString = $conditionString;
    }*/


    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getVlt()
    {
        return $this->vlt;
    }

    public function setVlt($vlt)
    {
        $this->vlt = $vlt;
    }

    public function getConditions()
    {
        return $this->conditions;
    }

    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    public function getManufacturerLensColor()
    {
        return $this->manufacturerLensColor;
    }

    public function setManufacturerLensColor($manufacturerLensColor)
    {
        $this->manufacturerLensColor = $manufacturerLensColor;
    }

    public function getLensColor()
    {
        return $this->lensColor;
    }

    public function setLensColor($lensColor)
    {
        $this->lensColor = $lensColor;
    }

    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

    public function getLensColorUrl()
    {
        return $this->lensColorUrl;
    }

    public function setLensColorUrl($lensColorUrl)
    {
        $this->lensColorUrl = $lensColorUrl;
    }

    public function getConditionString()
    {
        return $this->conditionString;
    }

    public function setConditionString($conditionString)
    {
        $this->conditionString = $conditionString;
    }

}