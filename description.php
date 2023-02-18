<?php
include('elements.php');

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

        if ($product->getJSONTechnologies() != null) {
            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);
            $description .= technologiesHeader($translations['INCLUDED TECHNOLOGIES']);

            foreach ($technologies as $i => $t) {
                $description .= gogglesTechnologies($t->getName(), $t->getDescription(), $t->getUrl(), $i);
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
            $description .= riadok($translations['polarization'], $translations['polarizationSentence'], "https://eyerim.com/content/wysiwyg/description/features_pictures/new_polarized_icon.jpg");

            $description .= divider();
        }

        if ($product->getBrandSentence() != null) {
            if ($product->getBrandLogoUrl() != null) {
                $description .= riadok($product->getBrand(), $product->getBrandSentence(), $product->getBrandLogoUrl());
            } else {
                $description .= $product->getBrandSentence();
            }
            $description .= divider();
        }

        if ($product->getModelSentence() != null) {
            if ($product->getFrameShapeUrl() != null) {
                $description .= riadok($product->getModel(), $product->getModelSentence(), $product->getFrameShapeUrl());
            } else {
                $description .= $product->getModelSentence();
            }
            $description .= divider();
        }

        $forWhomDesc = "<strong>" . $translations[$product->getAttributeSet()] . "</strong> ";
        $forWhomDesc .= "<strong>" . $product->getName() . "</strong>" . $translations['gender1'] . $product->getBrand() . $translations['gender2' . $product->getGender()] . $translations[$product->getFrameType()];
        $forWhomDesc .= $translations[$product->getFrameShape()] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations[$product->getFaceShape() . "Face"] . "</p>";
        $description .= riadok($translations['forWhom'], $forWhomDesc, $product->getFaceShapeUrl());

        $description .= divider();

        if ($product->getPhotochromic() == "Yes") {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/uv_photochrom.svg";
        } else if ($product->getAttributeSet() == "Sunglasses") {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/uv.svg";
        } else {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/glasses-material-icon.svg";
        }

        $materialsDesc = $translations['materialUsed'] . $translations[$product->getMaterial()] . (($product->getAttributeSet() == "Sunglasses") ? $translations['UVlight'] : "");
        $description .= riadok($translations['materials'], $materialsDesc, $materialsUrl);

        if ($product->getJSONTechnologies() != null) {
            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);
            foreach ($technologies as $t) {
                $description .= riadok($t->getName(), $t->getDescription(), $t->getUrl());
            }
        }

        $description .= divider();

        $description .= riadok($translations['freeDelivery'], $translations['delivery1'] . " <strong>" . $product->getName() . "</strong> " . $translations['delivery2'], "https://eyerim.com/content/wysiwyg/description/delivery.svg");

        $description .= $style->getGlassesStyle();
    }

    return $description;
}

