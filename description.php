<?php


function description($conn, $product, $countryCode, $style)
{
    include('locale/' . $countryCode . '.php');
    $description = "";

    $vlt = ($product->getLens()->getVlt() == null) ? "-" : $product->getLens()->getVlt() . "%";
    $lensSentence = null;
    $conditionString = ($product->getLens()->getConditionString() == null) ? "-" : $product->getLens()->getConditionString();
    $prizmVideo = "";
    $modulatorDefinition = null;
    $technologies = [];
    $lensConditions = ($product->getLens()->getConditions() == null) ? "-" : $product->getLens()->getConditions();
    $il_lensConditions = ($product->getInterLens()->getConditions() == null) ? "-" : $product->getInterLens()->getConditions();
    $il_vlt = ($product->getInterLens()->getVlt() == null) ? "-" : $product->getInterLens()->getVlt() . +"%";
    $il_condition = ($product->getInterLens()->getConditionString() == null) ? "-" : $product->getInterLens()->getConditionString();
    $lensGuideUrl = !in_array(strtolower($product->getBrand()), ["oakley", "bolle", "cebe", "smith"], true) ? "" : strtolower($product->getBrand());
    $lensGuideSentence = $lensGuideUrl === "" ? "" : $translations['lensGuideSentence'] . " <b><u><a href=\"../" . $lensGuideUrl . "-lens-guide\" target=\"_blank\">" . $translations['here'] . "</a></u></b>.";

    /*
     * START OF DESCRIPTION
     */

    if ($product->getCustomDescription() != null) {
        $description .= $product->getCustomDescription();
        return $description;
    }
    $description .= "<p>";

    if ("Ski Goggles" === $product->getAttributeSet()) {

        $description .= "<div class=\"sosovkainfo\">" .
            "<div class=\"sosovka\">";

        if ($product->getLens()->getPictureUrl() == null) {
            $description .= "<img src=\"https://eyerim.com/content/wysiwyg/description/lens_pictures/no-image.png\" alt=\"No image\" style=\"max-height: 9em;\">";
        } else {
            $description .= "<img src=\"" . $product->getLens()->getPictureUrl() . "\" alt=\"" . $product->getLens()->getManufacturerLensColor() . "\" style=\"max-height: 9em;\">";
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
            "<div class=\"stvrtina\" >" . $product->getLens()->getManufacturerLensColor() . "</div>" .
            "<div class=\"stvrtina\" >" .
            "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $product->getLens()->getLensColor() . "</div>" .
//            "<img src=\"" . $product->getLens()->getLensColorUrl() . "\" alt = \"" . $product->getLens()->getLensColor() . "\" style=\"max-height: 1em;\">" .
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
            if ($product->getJSONTechnologies() != null) {
                if (str_contains(strtolower($product->getJSONTechnologies()), "prizm")) {

                    $lensSentence = (isset($translations['prefix']) ? $translations['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations['PRIZMGoggles'];

                    $prizmVideo = "<div class=\"row\" style=\"margin-top: 50px\">" .
                        "<div class=\"col-sm-12 col-xs-12\" style=\"\">" .
                        "<div class=\"video\">" .
                        "<iframe src=\"https://www.youtube.com/embed/BBjovrbOJdY\" width=\"870\" height=\"489.375\" frameborder=\"0\" controls=\"0\" color=\"white\" allowfullscreen=\"\"></iframe>" .
                        "</div>" .
                        "</div>" .
                        "</div>";

                }

                if (str_contains(strtolower($product->getJSONTechnologies()), "chromapop")) {
                    $lensSentence = (isset($translations['prefix']) ? $translations['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations['CHROMAPOPGoggles'];

                }

                if (str_contains(strtolower($product->getJSONTechnologies()), "modulator")) {
                    $lensSentence = (isset($translations['prefix']) ? $translations['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations['MODULATORGoggles'];
                    $modulatorDefinition = $translations['MODULATORDefinition'];
                }
            }

            if ($lensSentence == null) {
                $lensSentence = (isset($translations['prefix']) ? $translations['prefix'] : "") . $product->getBrand() . $translations['premium'] . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations['lensIsPerfectFor']
                    . $conditionString . $translations['conditions'] . ".";
            }

            $modulatorDefinition = $modulatorDefinition != null ? $modulatorDefinition : "";

            $description .= "<p>" . $lensSentence . $translations['VLTOfLens'] . $product->getLens()->getManufacturerLensColor() . $translations['is'] . " <b>" . $vlt
                . "</b>" . $translations['VLTGoggles1'] . $vlt . $translations['VLTGoggles2'] . $modulatorDefinition
                . ". " . $lensGuideSentence . "</p>";
        }


        /*
         * INTERCHANGEABLE LENS
         */

        if ($product->getInterLens()->getManufacturerLensColor() != null) {

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

            if ($product->getInterLens()->getPictureUrl() == null) {
                $description .= "<img src=\"https://eyerim.com/content/wysiwyg/description/lens_pictures/no-image.png\" alt=\"No image\" style=\"max-height: 9em;\">";
            } else {
                $description .= "<img src=\"" . $product->getInterLens()->getPictureUrl() . "\" style=\"max-height: 9em;\">";
            }

            $description .= "    </div>" .
                "<div class=\"infocast\">" .
                "<div class=\"inforiadok\">" .
                "<div class=\"stvrtina\" >" . $product->getInterLens()->getManufacturerLensColor() . "</div>" .
                "<div class=\"stvrtina\" >" .
                "<div style=\"margin-top: 1.5em; margin-bottom: 0.5em;\">" . $product->getInterLens()->getLensColor() . "</div>" .
//                        "<img src=\"" . $product->getInterLens()->getLensColorUrl() . "\" style=\"max-height: 1em;\">" .
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

        if ($product->getJSONTechnologies() != null) {

            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);

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

        if ($product->getBrandSentence() != null) {
            $description .=
                "<p style=\"text-align: justify;\">" . $product->getBrandSentence() . "</p>";
        }
        $description .=
            "<p style=\"text-align: justify\">";

        if ($product->getGender() === "Women") {
            $description .= $translations['womenGoggles'];
        } else if ($product->getGender() === "Kids") {
            $description .= $translations['childrenGoggles'];
        } else {
            $description .= $translations['goggles'];
        }

        $description .= (isset($translations['prefix']) ? $translations['prefix'] : "") . "<b>" . $product->getModel() . "</b> " . $translations['brandGoggles1'] . $product->getBrand() . $translations['brandGoggles2'] . $product->getBrand() . $translations['brandGoggles3'] . "</p>";
        $description .= "<p style=\"text-align: justify\"><br>" . $translations['delivery1'] . " <strong>" . $product->getName() . "</strong> " . $translations['delivery2'] . "</p>";

        $description .= $style->getGogglesStyle();
    } else {

        if ($product->getBundleProductSentence() != null) {
            $description .= $product->getBundleProductSentence();
        }

        if ($product->getLens()->getPolarized() == "Yes") {
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


        if ($product->getBrandSentence() != null) {
            if ($product->getBrandLogoUrl() != null) {
                $description .= "<div class=\"riadok\">" .
                    "<div class=\"polovica lavo obrazok\">" .
                    "<img src=\"" . $product->getBrandLogoUrl() . "\" alt=\"tech\" style=\"width: 50%; vertical-align: middle;\">" .
                    "</div>" .
                    "<div class=\"stred\"></div>" .
                    "<div class=\"polovica pravo\">" .
                    "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $product->getBrand() . "</p>" .
                    $product->getBrandSentence() .
                    "</div>" .
                    "</div>" .
                    "</p>";
            } else {
                $description .= $product->getBrandSentence();
            }
            $description .=
                "<div style=\"font-weight: 600; text-align: center; margin-top: 1em; margin-bottom: 1em;\">" .
                "<div style=\"width: 100%; border-top: 1px solid #d0d2d3\">" .
                "</div>" .
                "</div>";
        }


        if ($product->getModelSentence() != null) {
            if ($product->getFrameShapeUrl() != null) {
                $description .=
                    "<div class=\"riadok\">" .
                    "<div class=\"polovica lavo obrazok\">" .
                    "<img src=\"" . $product->getFrameShapeUrl() . "\" alt=\"tech\" style=\"height: 10vh; vertical-align: middle;\">" .
                    "</div>" .
                    "<div class=\"stred\"></div>" .
                    "<div class=\"polovica pravo\">" .
                    "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $product->getModel() . "</p>" .
                    $product->getModelSentence() .
                    "</div>" .
                    "</div>" .
                    "</p>";
            } else {
                $description .= $product->getModelSentence();
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
            "<img src=\"" . $product->getFaceShapeUrl() . "\" alt=\"tech\" style=\"height: 10vh; vertical-align: middle;\">" .
            "</div>" .
            "<div class=\"stred\"></div>" .
            "<div class=\"polovica pravo\">" .
            "<p class=\"blok_nadpis\" style=\"font-size: 1.3em;\">" . $translations['forWhom'] . "</p>";

        if ($product->getAttributeSet() == "Sunglasses") {
            $description .= "<strong>" . $translations['sunglasses'] . "</strong> ";
        } else if ($product->getAttributeSet() == "Glasses") {
            $description .= "<strong>" . $translations['glasses'] . "</strong> ";
        }

        if ($product->getGender() == "Men") {
            $description .= "<strong>" . $product->getName() . "</strong>" . $translations['gender1'] . $product->getBrand() . $translations['gender2men'];
        } else if ($product->getGender() == "Women") {
            $description .= "<strong>" . $product->getName() . "</strong>" . $translations['gender1'] . $product->getBrand() . $translations['gender2women'];
        } else if ($product->getGender() == "Kids") {
            $description .= "<strong>" . $product->getName() . "</strong>" . $translations['gender1'] . $product->getBrand() . $translations['gender2kids'];
        } else if ($product->getGender() == "Men,Women") {
            $description .= "<strong>" . $product->getName() . "</strong>" . $translations['gender1'] . $product->getBrand() . $translations['gender2unisex'];
        }

        if ($product->getFrameType() == "Full-Rim") {
            $description .= $translations['fullrim'];
        } else if ($product->getFrameType() == "Half-Rim") {
            $description .= $translations['halfrim'];
        } else if ($product->getFrameType() == "Rimless") {
            $description .= $translations['rimless'];
        }

        if ($product->getFrameShape() == "Pilot") {
            $description .= $translations['pilot'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalSquaredFace'] . "</p>";
        } else if ($product->getFrameShape() == "Round") {
            $description .= $translations['round'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['squaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Oversize") {
            $description .= $translations['oversize'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundFace'] . "</p>";
        } else if ($product->getFrameShape() == "Oval") {
            $description .= $translations['oval'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalSquaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Cat Eye") {
            $description .= $translations['catEye'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Rectangular") {
            $description .= $translations['rectangular'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalFace'] . "</p>";
        } else if ($product->getFrameShape() == "Squared") {
            $description .= $translations['squared'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Single Lens") {
            $description .= $translations['singleLens'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundSquaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Browline") {
            $description .= $translations['browline'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalSquaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Tiny") {
            $description .= $translations['tiny'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalSquaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Special") {
            $description .= $translations['special'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundOvalSquaredHeartFace'] . "</p>";
        } else if ($product->getFrameShape() == "Flat Top") {
            $description .= $translations['flatTop'] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations['roundFace'] . "</p>";
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

        if ($product->getPhotochromic() == "Yes") {
            $description .= "https://eyerim.com/content/wysiwyg/description/features_pictures/uv_photochrom.svg";
        } else if ($product->getAttributeSet() == "Sunglasses") {
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

        $description .= $translations[$product->getMaterial()];

        if ($product->getAttributeSet() == "Sunglasses") {
            $description .= $translations['UVlight'];
        }

        $description .= "</p>";

        $description .=
            "</div>" .
            "</div>" .
            "</p>";

        if ($product->getJSONTechnologies() != null) {

            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);

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
            "<p>" . $translations['delivery1'] . " <strong>" . $product->getName() . "</strong> " . $translations['delivery2'] . "</p>" .
            "</div>" .
            "</div>" .
            "</p>";

        $description .= $style->getGlassesStyle();
    }

    return $description;
}

