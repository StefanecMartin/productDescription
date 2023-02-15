<?php


function description($product, $countryCode, $style){
    include 'locale/'.$countryCode.'.php';
    $description = "";

    $brandSentence = $product->getBrandSentence();
    $modelSentence = $product->getModelSentence();
    $bundleSentence = $product->getBundleProductSentence();
    $att_set = $product->getAttributeSet();
    $gender = $product->getGender();
    $brandName = $product->getBrand();
    $model = $product->getModel();
    $name = $product->getName();
    $frameType = $product->getFrameType();
    $frameShape = $product->getFrameShape();
    $modelGroup = $product->getModelGroup();
    $material = $product->getMaterial();
    $polarized = $product->getLens()->getPolarized();
    $JSONTechnologies = $product->getJSONTechnologies();
    $vlt = ($product->getLens()->getVlt() == null) ? "-":$product->getLens()->getVlt()."%";
    $lensSentence = null;
    $mLensColor = $product->getLens()->getManufacturerLensColor();
    $condition= ($product->getLens()->getConditionString() == null) ? "-":$product->getLens()->getConditionString();
    $prizmVideo = "";
    $modulatorDefinition = null;
    $bundleProductId = $product->getBundleProductId();
    $technologies = [];
    $lensUrl = $product->getLens()->getPictureUrl();
    $lensColor = $product->getLens()->getLensColor();
    $lensColorUrl = $product->getLens()->getLensColorUrl();
    $lensConditions = ($product->getLens()->getConditions() == null) ? "-":$product->getLens()->getConditions();
    $il_mLensColor = $product->getInterLens()->getManufacturerLensColor();
    $il_lensColor = $product->getInterLens()->getLensColor();
    $il_pictureUrl = $product->getInterLens()->getPictureUrl();
    $il_lensColorUrl = $product->getInterLens()->getLensColorUrl();
    $il_lensConditions = ($product->getInterLens()->getConditions() == null) ? "-":$product->getInterLens()->getConditions();
    $il_vlt = ($product->getInterLens()->getVlt() == null) ? "-":$product->getInterLens()->getVlt().+"%";
    $il_condition= ($product->getInterLens()->getConditionString() == null) ? "-":$product->getInterLens()->getConditionString();
    $lensGuideUrl = in_array(mb_strtolower($brandName),["oakley","bolle","cebe","smith"],true)?"":mb_strtolower($brandName);
    $lensGuideSentence = $lensGuideUrl==="" ? "":"Ak chcete vedieť viac informácií o VLT všetkých šošoviek, kliknite <b><u><a href=\"../" . $lensGuideUrl . "-lens-guide\" target=\"_blank\">tu</a></u></b>.</p> ";
    $frame_shape_url = $product->getFrameShapeUrl();
    $face_shape_url = $product->getFaceShapeUrl();
    $brand_logo_url = $product->getBrandLogoUrl();
    $photochromic = $product->getPhotochromic();
    $customDescription = $product->getCustomDescription();

        /*
         * START OF DESCRIPTION
         */
}

