<?php

class Product
{
    protected $productId, $bundleProductId, $modelId, $brandId;
    protected $sku;

    protected $modelGroup;
    protected $nickname;
    protected $model;
    protected $gender;
    protected $brand;
    protected $manufacturerSku;
    protected $brandSentence;
    protected $modelSentence;
    protected $bundleProductSentence;
    protected $attributeSet;
    protected $name;
    protected $frameShape;
    protected $faceShape;
    protected $frameType;
    protected $material;
    protected $JSONTechnologies;
    protected $frameShapeUrl;
    protected $faceShapeUrl;
    protected $brandLogoUrl;
    protected $photochromic;
    protected $polarized;
    protected $customDescription;


    protected array $technologies;
    protected $frame;
    protected $lens;
    protected $interLens;

    public function __construct()
    {
        $this->frame = new Frame();
        $this->lens = new Lens();
        $this->interLens = new InterLens();
    }

    public function getPolarized()
    {
        return $this->polarized;
    }

    public function setPolarized($polarized)
    {
        $this->polarized = $polarized;
    }

    public function getInterLens()
    {
        return $this->interLens;
    }

    public function setInterLens($interLens)
    {
        $this->interLens = $interLens;
    }

    public function getJSONTechnologies()
    {
        return $this->JSONTechnologies;
    }

    public function setJSONTechnologies($JSONTechnologies)
    {
        $this->JSONTechnologies = $JSONTechnologies;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAttributeSet()
    {
        return $this->attributeSet;
    }

    public function setAttributeSet($attributeSet)
    {
        $this->attributeSet = $attributeSet;
    }

    public function getBundleProductSentence()
    {
        return $this->bundleProductSentence;
    }

    public function setBundleProductSentence($bundleProductSentence)
    {
        $this->bundleProductSentence = $bundleProductSentence;
    }

    public function getBrandId()
    {
        return $this->brandId;
    }

    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;
    }

    public function getTechnologies()
    {
        return $this->technologies;
    }

    public function setTechnologies($technologies)
    {
        $this->technologies = $technologies;
    }

    public function getFrame()
    {
        return $this->frame;
    }

    public function setFrame($frame)
    {
        $this->frame = $frame;
    }

    public function getLens()
    {
        return $this->lens;
    }

    public function setLens($lens)
    {
        $this->lens = $lens;
    }

    public function getBrandSentence()
    {
        return $this->brandSentence;
    }

    public function setBrandSentence($brandSentence)
    {
        $this->brandSentence = $brandSentence;
    }

    public function getModelSentence()
    {
        return $this->modelSentence;
    }

    public function setModelSentence($modelSentence)
    {
        $this->modelSentence = $modelSentence;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getBundleProductId()
    {
        return $this->bundleProductId;
    }

    public function setBundleProductId($bundleProductId)
    {
        $this->bundleProductId = $bundleProductId;
    }

    public function getModelId()
    {
        return $this->modelId;
    }

    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getModelGroup()
    {
        return $this->modelGroup;
    }

    public function setModelGroup($modelGroup)
    {
        $this->modelGroup = $modelGroup;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getManufacturerSku()
    {
        return $this->manufacturerSku;
    }

    public function setManufacturerSku($manufacturerSku)
    {
        $this->manufacturerSku = $manufacturerSku;
    }

    public function getFrameShape()
    {
        return $this->frameShape;
    }

    public function setFrameShape($frameShape)
    {
        $this->frameShape = $frameShape;
    }

    public function getFrameType()
    {
        return $this->frameType;
    }

    public function setFrameType($frameType)
    {
        $this->frameType = $frameType;
    }


    public function setFaceShape($faceShape)
    {
        $this->faceShape = $faceShape;
    }

    public function getFaceShape()
    {
        return $this->faceShape;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }

    public function getFrameShapeUrl()
    {
        return $this->frameShapeUrl;
    }

    public function setFrameShapeUrl($frameShapeUrl)
    {
        $this->frameShapeUrl = $frameShapeUrl;
    }

    public function getFaceShapeUrl()
    {
        return $this->faceShapeUrl;
    }

    public function setFaceShapeUrl($faceShapeUrl)
    {
        $this->faceShapeUrl = $faceShapeUrl;
    }

    public function getBrandLogoUrl()
    {
        return $this->brandLogoUrl;
    }

    public function setBrandLogoUrl($brandLogoUrl)
    {
        $this->brandLogoUrl = $brandLogoUrl;
    }

    public function getPhotochromic()
    {
        return $this->photochromic;
    }

    public function setPhotochromic($photochromic)
    {
        $this->photochromic = $photochromic;
    }

    public function setCustomDescription($customDescription)
    {
        $this->customDescription = $customDescription;
    }

    public function getCustomDescription()
    {
        return $this->customDescription;
    }
}