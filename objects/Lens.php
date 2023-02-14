<?php

class Lens
{
    protected $manufacturerLensColorId;
    protected $lensColorId;
    protected $manufacturerLensColor;
    protected $lensColor;
    protected $vlt;
    protected $conditions;
    protected $category;
    protected $polarized;
    protected $lensId;
    protected $pictureUrl;
    protected $lensColorUrl;
    protected $conditionString;

    public function __construct()
    {

    }

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

    public function getManufacturerLensColorId()
    {
        return $this->manufacturerLensColorId;
    }

    public function setManufacturerLensColorId($manufacturerLensColorId)
    {
        $this->manufacturerLensColorId = $manufacturerLensColorId;
    }

    public function getLensColorId()
    {
        return $this->lensColorId;
    }

    public function setLensColorId($lensColorId)
    {
        $this->lensColorId = $lensColorId;
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

    public function getPolarized()
    {
        return $this->polarized;
    }

    public function setPolarized($polarized)
    {
        $this->polarized = $polarized;
    }

    public function getLensId()
    {
        return $this->lensId;
    }

    public function setLensId($lensId)
    {
        $this->lensId = $lensId;
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