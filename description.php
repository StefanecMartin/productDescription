<?php
include('elements.php');
include('locale.php');

function description($conn, $product, $countryCode, $style)
{
    global $translations;
    $description = "";

    $vlt = ($product->getLens()->getVlt() == null) ? "-" : $product->getLens()->getVlt() . "%";
    $lensSentence = null;
    $conditionString = ($product->getLens()->getConditionString() == null) ? "-" : $product->getLens()->getConditionString();
    $technologies = [];
    $lensConditions = ($product->getLens()->getConditions() == null) ? "-" : $product->getLens()->getConditions();
    $il_lensConditions = ($product->getInterLens()->getConditions() == null) ? "-" : $product->getInterLens()->getConditions();
    $il_vlt = ($product->getInterLens()->getVlt() == null) ? "-" : $product->getInterLens()->getVlt() . "%";
    $il_condition = ($product->getInterLens()->getConditionString() == null) ? "-" : $product->getInterLens()->getConditionString();
    $lensGuideUrl = !in_array(strtolower($product->getBrand()), ["oakley", "bolle", "cebe", "smith"], true) ? "" : strtolower($product->getBrand());
    $lensGuideSentence = $lensGuideUrl === "" ? "" : $translations[$countryCode]['lensGuideSentence'] . " <b><u><a href=\"../" . $lensGuideUrl . "-lens-guide\" target=\"_blank\">" . $translations[$countryCode]['here'] . "</a></u></b>.";

    /*
     * START OF DESCRIPTION
     */

    if ($product->getCustomDescription() != null) {
        $description .= $product->getCustomDescription();
        return $description;
    }
    $description .= "<p>";

    if ("Ski Goggles" === $product->getAttributeSet()) {
        $description .= sosovkaInfo($product->getLens()->getPictureUrl(), [$translations[$countryCode]['NAME'], $translations[$countryCode]['COLOR'], $translations[$countryCode]['CONDITIONS CAPS'], $translations[$countryCode]['VLT']], [$product->getLens()->getManufacturerLensColor(), $product->getLens()->getLensColor(), $lensConditions, $vlt]);

        /*
         * LENS SENTENCES
         * according to the lens technology, one of the lens sentences will be chosen (e.g. PRIZM or Modulator)
         * if vlt or conditions are missing, whole part will not be displayed
         */
        $modulatorDefinition = "";
        if ($vlt != "-" && $conditionString != "-") {
            if ($product->getJSONTechnologies() != null) {
                if (str_contains(strtolower($product->getJSONTechnologies()), "prizm")) {
                    $lensSentence = (isset($translations[$countryCode]['prefix']) ? $translations[$countryCode]['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations[$countryCode]['PRIZMGoggles'];
                }

                if (str_contains(strtolower($product->getJSONTechnologies()), "chromapop")) {
                    $lensSentence = (isset($translations[$countryCode]['prefix']) ? $translations[$countryCode]['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations[$countryCode]['CHROMAPOPGoggles'];
                }

                if (str_contains(strtolower($product->getJSONTechnologies()), "modulator")) {
                    $lensSentence = (isset($translations[$countryCode]['prefix']) ? $translations[$countryCode]['prefix'] : "") . $product->getBrand() . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations[$countryCode]['MODULATORGoggles'];
                    $modulatorDefinition = $translations[$countryCode]['MODULATORDefinition'];
                }
            }

            if ($lensSentence == null) {
                $lensSentence = (isset($translations[$countryCode]['prefix']) ? $translations[$countryCode]['prefix'] : "") . $product->getBrand() . $translations[$countryCode]['premium'] . " <b>" . $product->getLens()->getManufacturerLensColor() . "</b> " . $translations[$countryCode]['lensIsPerfectFor']
                    . $conditionString . $translations[$countryCode]['conditions'] . ".";
            }

            $description .= "<p>" . $lensSentence . $translations[$countryCode]['VLTOfLens'] . $product->getLens()->getManufacturerLensColor() . $translations[$countryCode]['is'] . " <b>" . $vlt
                . "</b>" . $translations[$countryCode]['VLTGoggles1'] . $vlt . $translations[$countryCode]['VLTGoggles2'] . $modulatorDefinition
                . ". " . $lensGuideSentence . "</p>";
        }

        /*
         * INTERCHANGEABLE LENS
         */
        if ($product->getInterLens()->getManufacturerLensColor() != null) {
            $description .= "<p style=\"text-align:center; margin-top: 2em;\">" . $translations[$countryCode]["extraLensIncluded"] . "</p>";
            $description .= sectionHeader($translations[$countryCode]["EXTRA LENS"]);
            $description .= sosovkaInfo($product->getInterLens()->getPictureUrl(), [$translations[$countryCode]['NAME'], $translations[$countryCode]['COLOR'], $translations[$countryCode]['CONDITIONS CAPS'], $translations[$countryCode]['VLT']], [$product->getInterLens()->getManufacturerLensColor(), $product->getInterLens()->getLensColor(), $il_lensConditions, $il_vlt]);
        } else {
            $description .= "<p style=\"text-align:center; margin-top: 2em;\">" . $translations[$countryCode]['extraLensNotIncluded'] . "</p>";
        }

        if ($product->getJSONTechnologies() != null) {
            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);
            $description .= sectionHeader($translations[$countryCode]['INCLUDED TECHNOLOGIES']);

            foreach ($technologies as $i => $t) {
                $description .= gogglesTechnologies($t->getName(), $t->getDescription(), $t->getUrl(), $i);
            }
        }

        $description .= sectionHeader($translations[$countryCode]['ABOUT BRAND']);

        if ($product->getBrandSentence() != null) {
            $description .=
                "<p style=\"text-align: justify;\">" . $product->getBrandSentence() . "</p>";
        }
        $description .=
            "<p style=\"text-align: justify\">";

        if ($product->getGender() === "Women") {
            $description .= $translations[$countryCode]['womenGoggles'];
        } else if ($product->getGender() === "Kids") {
            $description .= $translations[$countryCode]['childrenGoggles'];
        } else {
            $description .= $translations[$countryCode]['goggles'];
        }

        $description .= (isset($translations[$countryCode]['prefix']) ? $translations[$countryCode]['prefix'] : "") . "<b>" . $product->getModel() . "</b> " . $translations[$countryCode]['brandGoggles1'] . $product->getBrand() . $translations[$countryCode]['brandGoggles2'] . $product->getBrand() . $translations[$countryCode]['brandGoggles3'] . "</p>";
        $description .= "<p style=\"text-align: justify\"><br>" . $translations[$countryCode]['delivery1'] . " <strong>" . $product->getName() . "</strong> " . $translations[$countryCode]['delivery2'] . "</p>";
        $description .= $style->getGogglesStyle();
    } else {
        if ($product->getBundleProductSentence() != null) {
            $description .= $product->getBundleProductSentence();
        }

        if ($product->getLens()->getPolarized() == "Yes") {
            $description .= riadok($translations[$countryCode]['polarization'], $translations[$countryCode]['polarizationSentence'], "https://eyerim.com/content/wysiwyg/description/features_pictures/new_polarized_icon.jpg");

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

        $forWhomDesc = "<strong>" . $translations[$countryCode][$product->getAttributeSet()] . "</strong> ";
        $forWhomDesc .= "<strong>" . $product->getName() . "</strong>" . $translations[$countryCode]['gender1'] . $product->getBrand() . $translations[$countryCode]['gender2' . $product->getGender()] . $translations[$countryCode][$product->getFrameType()];
        $forWhomDesc .= $translations[$countryCode][$product->getFrameShape()] . " <strong>" . $product->getBrand() . " " . $product->getModelGroup() . "</strong> " . $translations[$countryCode][$product->getFaceShape() . "Face"] . "</p>";
        $description .= riadok($translations[$countryCode]['forWhom'], $forWhomDesc, $product->getFaceShapeUrl());

        $description .= divider();

        if ($product->getPhotochromic() == "Yes") {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/uv_photochrom.svg";
        } else if ($product->getAttributeSet() == "Sunglasses") {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/uv.svg";
        } else {
            $materialsUrl = "https://eyerim.com/content/wysiwyg/description/features_pictures/glasses-material-icon.svg";
        }

        $materialsDesc = $translations[$countryCode]['materialUsed'] . $translations[$countryCode][$product->getMaterial()] . (($product->getAttributeSet() == "Sunglasses") ? $translations[$countryCode]['UVlight'] : "");
        $description .= riadok($translations[$countryCode]['materials'], $materialsDesc, $materialsUrl);

        if ($product->getJSONTechnologies() != null) {
            $technologies = selectTechnologies($conn, $product->getBundleProductId(), $countryCode);
            foreach ($technologies as $t) {
                $description .= riadok($t->getName(), $t->getDescription(), $t->getUrl());
            }
        }

        $description .= divider();

        $description .= riadok($translations[$countryCode]['freeDelivery'], $translations[$countryCode]['delivery1'] . " <strong>" . $product->getName() . "</strong> " . $translations[$countryCode]['delivery2'], "https://eyerim.com/content/wysiwyg/description/delivery.svg");

        $description .= $style->getGlassesStyle();
    }

    return $description;
}

