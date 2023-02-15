<?php


function description($conn, $product, $countryCode, $style)
{
    include('locale/' . $countryCode . '.php');
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
    $vlt = ($product->getLens()->getVlt() == null) ? "-" : $product->getLens()->getVlt() . "%";
    $lensSentence = null;
    $mLensColor = $product->getLens()->getManufacturerLensColor();
    $conditionString = ($product->getLens()->getConditionString() == null) ? "-" : $product->getLens()->getConditionString();
    $prizmVideo = "";
    $modulatorDefinition = null;
    $bundleProductId = $product->getBundleProductId();
    $technologies = [];
    $lensUrl = $product->getLens()->getPictureUrl();
    $lensColor = $product->getLens()->getLensColor();
    $lensColorUrl = $product->getLens()->getLensColorUrl();
    $lensConditions = ($product->getLens()->getConditions() == null) ? "-" : $product->getLens()->getConditions();
    $il_mLensColor = $product->getInterLens()->getManufacturerLensColor();
    $il_lensColor = $product->getInterLens()->getLensColor();
    $il_pictureUrl = $product->getInterLens()->getPictureUrl();
    $il_lensColorUrl = $product->getInterLens()->getLensColorUrl();
    $il_lensConditions = ($product->getInterLens()->getConditions() == null) ? "-" : $product->getInterLens()->getConditions();
    $il_vlt = ($product->getInterLens()->getVlt() == null) ? "-" : $product->getInterLens()->getVlt() . +"%";
    $il_condition = ($product->getInterLens()->getConditionString() == null) ? "-" : $product->getInterLens()->getConditionString();
    $lensGuideUrl = !in_array(mb_strtolower($brandName), ["oakley", "bolle", "cebe", "smith"], true) ? "" : mb_strtolower($brandName);
    $lensGuideSentence = $lensGuideUrl === "" ? "" : $translations['lensGuideSentence'] . " <b><u><a href=\"../" . $lensGuideUrl . "-lens-guide\" target=\"_blank\">" . $translations['here'] . "</a></u></b>.";
    $frame_shape_url = $product->getFrameShapeUrl();
    $face_shape_url = $product->getFaceShapeUrl();
    $brand_logo_url = $product->getBrandLogoUrl();
    $photochromic = $product->getPhotochromic();
    $customDescription = $product->getCustomDescription();

    /*
     * START OF DESCRIPTION
     */

    if ($customDescription != null) {
        $description .= $customDescription;
        return $description;
    }
    $description .= "<p>";

    if ("Ski Goggles" === $att_set) {

        $description .= "<div class=\"sosovkainfo\">" .
            "<div class=\"sosovka\">";

        if ($lensUrl == null) {
            $description .= "<img src=\"https://eyerim.com/content/wysiwyg/description/lens_pictures/no-image.png\" alt=\"No image\" style=\"max-height: 9em;\">";
        } else {
            $description .= "<img src=\"" . $lensUrl . "\" alt=\"" . $mLensColor . "\" style=\"max-height: 9em;\">";
        }


        $description .= "</div>" .
            "<div class=\"infocast\">" .
            "<div class=\"inforiadok\">" .
            "<div class=\"stvrtina\" style=\"font-weight: bold;\">" . $translations['NAME'] . "</div>" .
            "<div class=\"stvrtina\" style=\"font-weight: bold;\">" . $translations['COLOR'] . "</div>" .
            "<div class=\"stvrtina\" style=\"font-weight: bold;\">" . $translations['CONDITIONS'] . "</div>" .
            "<div class=\"stvrtina\" style=\"font-weight: bold;\">" . $translations['VLT'] . "</div>" .
            "</div>" .
            "<div class=\"inforiadok\">" .
            "<div class=\"stvrtina\" >" . $mLensColor . "</div>" .
            "<div class=\"stvrtina\" >" .
            "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $lensColor . "</div>" .
//            "<img src=\"" . $lensColorUrl . "\" alt = \"" . $lensColor . "\" style=\"max-height: 1em;\">" .
            "</div>" .
            "<div class=\"stvrtina\" >" .
            "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $lensConditions . "</div>" .
            "</div>" .
            "<div class=\"stvrtina\" >" . $vlt . "</div>" .
            "</div>" .
            "</div>" .
            "</div>";

        /*
         * LENS SENTENCES
         * according to the lens technology, one of the lens sentences will be choosen (e.g. PRIZM or Modulator)
         * if vlt or conditions are missing, whole part will not be displayed
         */

        if ($vlt != "-" && $conditionString != "-") {
            if ($JSONTechnologies != null) {
                if (str_contains(mb_strtolower($JSONTechnologies), "prizm")) {

                    $lensSentence = $brandName . " <b>" . $mLensColor . "</b> " . $translations['PRIZMGoggles'];

                    $prizmVideo = "<div class=\"row\" style=\"margin-top: 50px\">" .
                        "<div class=\"col-sm-12 col-xs-12\" style=\"\">" .
                        "<div class=\"video\">" .
                        "<iframe src=\"https://www.youtube.com/embed/BBjovrbOJdY\" width=\"870\" height=\"489.375\" frameborder=\"0\" controls=\"0\" color=\"white\" allowfullscreen=\"\"></iframe>" .
                        "</div>" .
                        "</div>" .
                        "</div>";

                }

                if (str_contains(mb_strtolower($JSONTechnologies), "chromapop")) {
                    $lensSentence = $brandName . " <b>" . $mLensColor . "</b> " . $translations['CHROMAPOPGoggles'];

                }

                if (str_contains(mb_strtolower($JSONTechnologies), "modulator")) {
                    $lensSentence = $brandName . " <b>" . $mLensColor . "</b> " . $translations['MODULATORGoggles'];
                    $modulatorDefinition = $translations['MODULATORDefinition'];
                }
            }

            if ($lensSentence == null) {
                $lensSentence = $brandName . $translations['premium'] . " <b>" . $mLensColor . "</b> " . $translations['lensIsPerfectFor']
                    . $conditionString . $translations['conditions'] . ".";
            }

            $modulatorDefinition = $modulatorDefinition != null ? $modulatorDefinition : "";

            $description .= "<p>" . $lensSentence . $translations['VLTOfLens'] . $mLensColor . $translations['is'] . " <b>" . $vlt
                . "</b>" . $translations['VLTGoggles1'] . $vlt . $translations['VLTGoggles2'] . $modulatorDefinition
                . ". " . $lensGuideSentence . "</p>";
        }


        /*
         * INTERCHANGEABLE LENS
         */

        if ($il_mLensColor != null) {

            $description .= "<p style=\"text-align:center; margin-top: 2em;\">" . $translations["extraLensIncluded"] . "</p>";

            $description .= "<div style=\"font-weight: 600; text-align: center; margin-top: 3em; margin-bottom: 1em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
                "<span style=\"background-color: #fff; padding: 0 5px; position: relative; top: -10px; letter-spacing: 2px; font-size: 12.65px;\">" .
                $translations["EXTRA LENS"] .
                "</span>" .
                "</div>" .
                "</div>" .
                "<div class=\"sosovkainfo\" style=\"width: 100%\">" .
                "<div class=\"sosovka\">";

            if ($il_pictureUrl == null) {
                $description .= "<img src=\"https://eyerim.com/content/wysiwyg/description/lens_pictures/no-image.png\" alt=\"No image\" style=\"max-height: 9em;\">";
            } else {
                $description .= "<img src=\"" . $il_pictureUrl . "\" style=\"max-height: 9em;\">";
            }

            $description .= "    </div>" .
                "<div class=\"infocast\">" .
                "<div class=\"inforiadok\">" .
                "<div class=\"stvrtina\" >" . $il_mLensColor . "</div>" .
                "<div class=\"stvrtina\" >" .
                "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $il_lensColor . "</div>" .
//                        "<img src=\"" . $il_lensColorUrl . "\" style=\"max-height: 1em;\">" .
                "</div>" .
                "<div class=\"stvrtina\" >" .
                "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $il_lensConditions . "</div>" .
                "</div>" .
                "<div class=\"stvrtina\" >" . $il_vlt . "</div>" .
                "</div>" .
                "</div>" .
                "</div>";
        } else {
            $description .= "<p style=\"text-align:center; margin-top: 2em;\">" . $translations['extraLensNotIncluded'] . "</p>";
        }

        /*
         * INCLUDEED TECHNOLOGIES
         */

        if ($JSONTechnologies != null) {

            $technologies = selectTechnologies($conn, $bundleProductId, $countryCode);

            $description .= "<div style = \"font-weight: 600; text-align: center; margin-top: 3em; margin-bottom: 2em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\"><span style=\"background-color: #fff; " .
                "padding: 0 5px; position: relative; top: -10px; letter-spacing: 2px; font-size: 12.65px;\">"
                . $translations['INCLUDED TECHNOLOGIES'] . "</span></div></div>";
            $techCount = 1;

            foreach ($technologies as $t) {

                if ($techCount % 2 != 0) {

                    if ($t->getUrl() != null) {
                        $description .=
                            "<div class=\"riadok\">" .
                            "<div class=\"polovica lavo obrazok\">" .
                            "<img src=\"" . $t->getUrl() . "\" alt=\"" . $t->getName() . "\" style=\"max-width: 80%;\">" .
                            "</div>" .
                            "<div class=\"stred\"></div>" .
                            "<div class=\"polovica pravo\">" . $t->getDescription() .
                            "</div>" .
                            "</div>";

                    } else {
                        $description .= "<div class=\"riadok\">" .
                            "<div class=\"polovica lavo obrazok\" style=\"font-size:300%\">" . $t->getName() .
                            "</div>" .
                            "<div class=\"stred\"></div>" .
                            "<div class=\"polovica pravo\">" . $t->getDescription() .
                            "</div>" .
                            "</div>";
                    }

                } else {

                    if ($t->getUrl() != null) {
                        $description .=
                            "<div class=\"riadok\">" .
                            "<div class=\"polovica pravo obrazok\">" .
                            "<img src=\"" . $t->getUrl() . "\" alt=\"" . $t->getName() . "\" style=\"max-width: 80%;\">" .
                            "</div>" .
                            "<div class=\"stred\"></div>" .
                            "<div class=\"polovica lavo\">" . $t->getDescription() .
                            "</div>" .
                            "</div>";

                    } else {
                        $description .= "<div class=\"riadok\">" .
                            "<div class=\"polovica pravo obrazok\" style=\"font-size:300%\">" . $t->getName() .
                            "</div>" .
                            "<div class=\"stred\"></div>" .
                            "<div class=\"polovica lavo\">" . $t->getDescription() .
                            "</div>" .
                            "</div>";
                    }

                }

                $techCount += 1;

            }

        }

        $description .=
            "<p></p>" .
            "<div style=\"font-weight: 600; text-align: center; margin-top: 3em; margin-bottom: 2em;\">" .
            "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
            "<span style=\"background-color: #fff; padding: 0 5px; position: relative; top: -10px; letter-spacing: 2px; font-size: 12.65px;\">" .
            $translations['ABOUT BRAND'] .
            "</span>" .
            "</div>" .
            "</div>";

        if ($brandSentence != null) {
            $description .=
                "<p style=\"text-align: justify;\">" . $brandSentence . "</p>";
        }
        $description .=
            "<p style=\"text-align: justify\">";

        if ($gender === "Women") {
            $description .= $translations['womenGoggles'];
        } else if ($gender === "Kids") {
            $description .= $translations['childrenGoggles'];
        } else {
            $description .= $translations['goggles'];
        }

        $description .= "<b>" . $model . "</b> " . $translations['brandGoggles1'] . $brandName . $translations['brandGoggles2'] . $brandName . $translations['brandGoggles3'] . "</p>";
        $description .= "<p style=\"text-align: justify\"><br>" . $translations['delivery1'] . " <strong>" . $name . "</strong> " . $translations['delivery2'] . "</p>";

        $description .= $style->getGogglesStyle();
    }
    else {

        if ($bundleSentence != null) {
            $description .= $bundleSentence;
        }

        if ($polarized == "Yes") {
            $description .= "<div class=\"riadok\">" .
                "<div class=\"polovica lavo obrazok\">" .
                "<img src=\"https://eyerim.com/content/wysiwyg/description/features_pictures/new_polarized_icon.jpg\" alt=\"polarized\" style=\"width: 80%;vertical-align: middle;\">" .
                "</div>" .
                "<div class=\"stred\"></div>" .
                "<div class=\"polovica pravo\">" .
                "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $translations['polarization'] . "</p>" .
                "<p>" . $translations['polarizationSentence'] . "</p>" .
                "</div>" .
                "</div>" .
                "</p>";

            $description .=
                "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
                "</div>" .
                "</div>";
        }


        if ($brandSentence != null) {
            if ($brand_logo_url != null) {
                $description .= "<div class=\"riadok\">" .
                    "<div class=\"polovica lavo obrazok\">" .
                    "<img src=\"" . $brand_logo_url . "\" alt=\"tech\" style=\"width: 50%; vertical-align: middle;\">" .
                    "</div>" .
                    "<div class=\"stred\"></div>" .
                    "<div class=\"polovica pravo\">" .
                    "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $brandName . "</p>" .
                    $brandSentence .
                    "</div>" .
                    "</div>" .
                    "</p>";
            } else {
                $description .= $brandSentence;
            }
            $description .=
                "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
                "</div>" .
                "</div>";
        }


        if ($modelSentence != null) {
            if ($frame_shape_url != null) {
                $description .=
                    "<div class=\"riadok\">" .
                    "<div class=\"polovica lavo obrazok\">" .
                    "<img src=\"" . $frame_shape_url . "\" alt=\"tech\" style=\"height: 10vh; vertical-align: middle;\">" .
                    "</div>" .
                    "<div class=\"stred\"></div>" .
                    "<div class=\"polovica pravo\">" .
                    "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $model . "</p>" .
                    $modelSentence .
                    "</div>" .
                    "</div>" .
                    "</p>";
            } else {
                $description .= $modelSentence;
            }
            $description .=
                "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
                "</div>" .
                "</div>";
        }


        $description .=
            "<div class=\"riadok\">" .
            "<div class=\"polovica lavo obrazok\">" .
            "<img src=\"" . $face_shape_url . "\" alt=\"tech\" style=\"height: 10vh; vertical-align: middle;\">" .
            "</div>" .
            "<div class=\"stred\"></div>" .
            "<div class=\"polovica pravo\">" .
            "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $translations['forWhom'] . "</p>";

        if ($att_set == "Sunglasses") {
            $description .= "<strong>" . $translations['sunglasses'] . "</strong> ";
        } else if ($att_set == "Glasses") {
            $description .= "<strong>" . $translations['glasses'] . "</strong> ";
        }

        if ($gender == "Men") {
            $description .= "<strong>" . $name . "</strong>" . $translations['gender1'] . $brandName . $translations['gender2men'];
        } else if ($gender == "Women") {
            $description .= "<strong>" . $name . "</strong>" . $translations['gender1'] . $brandName . $translations['gender2women'];
        } else if ($gender == "Kids") {
            $description .= "<strong>" . $name . "</strong>" . $translations['gender1'] . $brandName . $translations['gender2kids'];
        } else if ($gender == "Men,Women") {
            $description .= "<strong>" . $name . "</strong>" . $translations['gender1'] . $brandName . $translations['gender2unisex'];
        }

        if ($frameType == "Full-Rim") {
            $description .= $translations['fullrim'];
        } else if ($frameType == "Half-Rim") {
            $description .= $translations['halfrim'];
        } else if ($frameType == "Rimless") {
            $description .= $translations['rimless'];
        }

        if ($frameShape == "Pilot") {
            $description .= $translations['pilot'] . $brandName . " " . $modelGroup . $translations['roundOvalSquaredFace'];
        } else if ($frameShape == "Round") {
            $description .= $translations['round'] . $brandName . " " . $modelGroup . $translations['squaredHeartFace'];
        } else if ($frameShape == "Oversize") {
            $description .= $translations['oversize'] . $brandName . " " . $modelGroup . $translations['roundFace'];
        } else if ($frameShape == "Oval") {
            $description .= $translations['oval'] . $brandName . " " . $modelGroup . $translations['roundOvalSquaredHeartFace'];
        } else if ($frameShape == "Cat Eye") {
            $description .= $translations['catEye'] . $brandName . " " . $modelGroup . $translations['roundOvalHeartFace'];
        } else if ($frameShape == "Rectangular") {
            $description .= $translations['rectangular'] . $brandName . " " . $modelGroup . $translations['roundOvalFace'];
        } else if ($frameShape == "Squared") {
            $description .= $translations['squared'] . $brandName . " " . $modelGroup . $translations['roundOvalHeartFace'];
        } else if ($frameShape == "Single Lens") {
            $description .= $translations['singleLens'] . $brandName . " " . $modelGroup . $translations['roundSquaredHeartFace'];
        } else if ($frameShape == "Browline") {
            $description .= $translations['browline'] . $brandName . " " . $modelGroup . $translations['roundOvalSquaredHeartFace'];
        } else if ($frameShape == "Tiny") {
            $description .= $translations['tiny'] . $brandName . " " . $modelGroup . $translations['roundOvalSquaredHeartFace'];
        } else if ($frameShape == "Special") {
            $description .= $translations['special'] . $brandName . " " . $modelGroup . $translations['roundOvalSquaredHeartFace'];
        } else if ($frameShape == "Flat Top") {
            $description .= $translations['flatTop'] . $brandName . " " . $modelGroup . $translations['roundFace'];
        }

        $description .=
            "</div>" .
            "</div>" .
            "</p>";

        $description .=
            "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
            "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
            "</div>" .
            "</div>";

        $description .=
            "<div class=\"riadok\">" .
            "<div class=\"polovica lavo obrazok\">" .
            "<img src=\"";

        if ($photochromic == "Yes") {
            $description .= "https://eyerim.com/content/wysiwyg/description/features_pictures/uv_photochrom.svg";
        } else if ($att_set == "Sunglasses") {
            $description .= "https://eyerim.com/content/wysiwyg/description/features_pictures/uv.svg";
        } else {
            $description .= "https://eyerim.com/content/wysiwyg/description/features_pictures/glasses-material-icon.svg";
        }


        $description .= "\" alt=\"tech\" style=\"height: 10vh; vertical-align: middle;\">" .
            "</div>" .
            "<div class=\"stred\"></div>" .
            "<div class=\"polovica pravo\">" .
            "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $translations['materials'] . "</p>";

        $description .= "<p>" . $translations['materialUsed'];

        $description .= $translations[$material];

        if ($att_set == "Sunglasses") {
            $description .= $translations['UVlight'];
        }

        $description .= "</p>";

        $description .=
            "</div>" .
            "</div>" .
            "</p>";

        if ($JSONTechnologies != null) {

            $technologies = selectTechnologies($conn, $bundleProductId, $countryCode);

            foreach ($technologies as $t) {

                if ($t->getUrl() != null) {
                    $description .=
                        "<div style=\"margin:3em;\"></div>" .
                        "<div class=\"riadok\">" .
                        "<div class=\"polovica lavo obrazok\">" .
                        "<img src=\"" . $t->getUrl() . "\" alt=\"" . $t->getName() . "\" style=\"max-width: 80%;\">" .
                        "</div>" .
                        "<div class=\"stred\"></div>" .
                        "<div class=\"polovica pravo\">" .
                        "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $t->getName() . "</p>" .
                        "<p>" . $t->getDescription() . "</p>" .
                        "</div>" .
                        "</div>";

                } else {
                    $description .=
                        "<div style=\"margin:3em;\"></div>" .
                        "<div class=\"riadok\">" .
                        "<div class=\"polovica lavo obrazok\" style=\"font-size:300%\">" . $t->getName() .
                        "</div>" .
                        "<div class=\"stred\"></div>" .
                        "<div class=\"polovica pravo\">" .
                        "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $t->getName() . "</p>" .
                        "<p>" . $t->getDescription() . "</p>" .
                        "</div>" .
                        "</div>";
                }
            }
        }

        $description .=
            "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
            "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
            "</div>" .
            "</div>";

        $description .=
            "<div class=\"riadok\">" .
            "<div class=\"polovica lavo obrazok\">" .
            "<img src=\"https://eyerim.com/content/wysiwyg/description/delivery.svg\" alt=\"tech\" style=\"height: 8vh;vertical-align: middle;\">" .
            "</div>" .
            "<div class=\"stred\"></div>" .
            "<div class=\"polovica pravo\">" .
            "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $translations['freeDelivery'] . "</p>" .
            "<p>" . $translations['delivery1'] . " <strong>" . $name . "</strong> " . $translations['delivery2'] . "</p>" .
            "</div>" .
            "</div>" .
            "</p>";

        $description .= $style->getGlassesStyle();
    }

    return $description;
}

