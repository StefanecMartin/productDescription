<?php
define('HOST', '10.80.48.52');
define('USER', 'onix');
define('PASS', 'Yezu4FdAQicOwmwq3TAQ');
define('DB', 'onix');

include "./objects/Product.php";
include "./objects/Lens.php";
include "./objects/InterLens.php";
include "./objects/Frame.php";
include "./objects/Country.php";
include "./objects/Technology.php";


function getConn()
{
    $conn = mysqli_connect(HOST, USER, PASS, DB);
    if ($conn) {
        echo 'CONNECTED TO DB<br>';
        return $conn;
    } else {
        echo 'NO CONNECTION<br>';
        return null;
    }
}

function closeConn($conn)
{
    mysqli_close($conn);
}

function selectCountries($conn)
{
    $result = mysqli_query($conn, 'select distinct country_id, country.code, country.shopsys_code from product_description_test product_description join country on product_description.country_id = country.id where country.is_active = 1;');
    $countries = [];
    while ($row = mysqli_fetch_array($result)) {
        $country = new Country();
        $country->setId($row['country_id']);
        $country->setCode($row['code'] === "INT"?"EN":$row['code']);
        $country->setShopsysCode($row['shopsys_code']);
        $countries[] = $country;
    }
    return $countries;
}

function createHelpTables($conn, $countryCode)
{
    $query1 = "create table lens_conditions_description AS " .
        "select l.id as lens_id, if(group_concat(c.id SEPARATOR ',') = '1,2,3,4', SUBSTRING_INDEX(SUBSTRING_INDEX(group_concat(c.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '),' / ',4),' / ',-1) ,group_concat(c.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '))  as lens_conditions, " .
        "if(group_concat(c.id SEPARATOR ',') = '1,2,3,4', SUBSTRING_INDEX(SUBSTRING_INDEX(group_concat(c2.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '),' / ',4),' / ',-1) ,group_concat(c2.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '))  as condition_string " .
        "FROM lens l " .
        "join lens_conditions ON l.id = lens_conditions.lens_id " .
        "join conditions c2 ON lens_conditions.conditions_id = c2.id " .
        "join conditions_description c ON lens_conditions.conditions_id = c.id " .
        "GROUP BY l.id;";

    $query2 = "create table bundle_details_description as " .
        "select " .
        "bundle_product.id as bundle_product_id ,t2.concat as technologies, t10.il_man_lens_color, t10.il_lens_color, t10.il_lens_color_url,  t10.il_vlt, t10.il_category, t10.il_picture_url, t10.il_lens_conditions, t10.condition_string as il_condition_string " .
        "from bundle_product " .
        "left join (select " .
        "bundle_product.id as bundle_product_id, group_concat(description.en_name separator ',') as concat " .
        "from " .
        "bundle_product join product_technologies on bundle_product.id = product_technologies.bundle_product_id join technologies_description description ON product_technologies.technologies_desc_id = description.id " .
        "group by bundle_product.id) t2 on t2.bundle_product_id = bundle_product.id " .
        "left join(" .
        "select bundle_product_id, m.color as il_man_lens_color, l.vlt as il_vlt, l.category as il_category, lens_pictures.url as il_picture_url, lct." . mb_strtolower($countryCode) . "_text as il_lens_color, lc.picture_url as il_lens_color_url, lcd.lens_conditions as il_lens_conditions, lcd.condition_string " .
        "from bundle_product " .
        "left join interchangeable_lens on bundle_product.id = interchangeable_lens.bundle_product_id " .
        "join lens l ON interchangeable_lens.lens_id = l.id " .
        "join manufacturer_lens_color m ON l.manufacturer_lens_color_id = m.id " .
        "left join lens_pictures on lens_pictures.lens_id = l.id " .
        "left join lens_conditions_description lcd on l.id = lcd.lens_id " .
        "join lens_color lc on l.lens_color_id = lc.id " .
        "join lens_color_translations lct on lct.lens_color_id = lc.id)t10 on t10.bundle_product_id = bundle_product.id; ";

    $query3 = "alter table lens_conditions_description add FOREIGN KEY (lens_id) REFERENCES lens (id);";

    $query4 = "alter table bundle_details_description add FOREIGN KEY (bundle_product_id) REFERENCES bundle_product (id);";

    $query5 = "drop table if exists lens_conditions_description;";

    $query6 = "drop table if exists bundle_details_description;";

    if (!mysqli_query($conn, $query5)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query6)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query1)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query2)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query3)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query4)) {
        echo("Error description: " . mysqli_error($conn));
    }

    echo 'Help tables created!<br>';
}

function dropHelpTables($conn)
{
    $query1 = 'drop table lens_conditions_description';

    $query2 = 'drop table bundle_details_description';

    if (!mysqli_query($conn, $query1)) {
        echo("Error description: " . mysqli_error($conn));
    }
    if (!mysqli_query($conn, $query2)) {
        echo("Error description: " . mysqli_error($conn));
    }

    echo 'Help tables dropped!<br>';
}

function selectProductData($conn, $countryCode, $countryId)
{
    $query = "select distinct " .
        "bundle_product.bundle_sku as sku, " .
        "bundle_product.id as bundle_product_id, " .
        "attribute_set.label as attribute_set, " .
        "model.model_group, " .
        "gender.label as gender, " .
        "frame_shape.frame_shape, " .
        "frame_shape.frame_shape_url, " .
        "frame_shape.face_shape_url, " .
        "frame_type.frame_type, " .
        "if(polarized.bundle_product_id is null,'No','Yes') as polarized, " .
        "if(pf.features_id is null,'No','Yes') as photochromic, " .
        "material.label as material, " .
        "lens.category as category, " .
        "lens.vlt as vlt, " .
        "manufacturer_lens_color.color as manufacturer_lens_color, " .
        "lct." . mb_strtolower($countryCode) . "_text as lens_color, " .
        "lens_color.picture_url as lens_color_url, " .
        "lens_conditions_description.lens_conditions as lens_conditions, " .
        "lens_conditions_description.condition_string as condition_string, " .
        "lens_pictures.url as lens_url, " .
        "brand.name as brand, " .
        "brand.brand_logo_url, " .
        "bundle_product.manufacturer_sku, " .
        "naming_system.model as model, " .
        "naming_system.name as name, " .
        "brand_sentences." . mb_strtolower($countryCode) . "_text as brand_sentence_" . mb_strtolower($countryCode) . ", " .
        "model_sentences." . mb_strtolower($countryCode) . "_text as model_sentence_" . mb_strtolower($countryCode) . ", " .
        "bundle_product_sentences." . mb_strtolower($countryCode) . "_text as bundle_sentence_" . mb_strtolower($countryCode) . ", " .
        "bdd.technologies, " .
        "bdd.il_man_lens_color, " .
        "bdd.il_lens_color, " .
        "bdd.il_vlt, " .
        "bdd.il_category, " .
        "bdd.il_lens_conditions, " .
        "bdd.il_lens_color_url, " .
        "bdd.il_picture_url, " .
        "bdd.il_condition_string, " .
        "cd.text as custom_description_" . mb_strtolower($countryCode) . " " .
        "from " .
        "product " .
        "join bundle_product on (product.bundle_product_id = bundle_product.id) " .
        "join model on (bundle_product.model_id = model.id) " .
        "join brand on (model.brand_id = brand.id) " .
        "join attribute_set on (model.attribute_set_id = attribute_set.id) " .
        "join frame_shape on (model.frame_shape_id = frame_shape.id) " .
        "join frame_type on (model.frame_type_id = frame_type.id) " .
        "left join product_features pf ON (bundle_product.id = pf.bundle_product_id and features_id = 7) " .
        "join lens on bundle_product.lens_id = lens.id " .
        "left join lens_pictures on lens_pictures.lens_id = lens.id " .
        "join manufacturer_lens_color on lens.manufacturer_lens_color_id = manufacturer_lens_color.id " .
        "join lens_color on lens.lens_color_id = lens_color.id " .
        "join lens_color_translations lct on lct.lens_color_id = lens_color.id " .
        "left join lens_conditions_description on lens_conditions_description.lens_id = lens.id " .
        "join manufacturer_material on (model.manufacturer_material_id = manufacturer_material.id) " .
        "join material on (manufacturer_material.material_id = material.id) " .
        "join gender on (gender.id = model.gender_id) " .
        "join naming_system on (product.id = naming_system.product_id) " .
        "left join polarized on polarized.bundle_product_id = bundle_product.id " .
        "left join interchangeable_lens on interchangeable_lens.bundle_product_id = bundle_product.id " .
        "left join brand_sentences ON brand.id = brand_sentences.brand_id " .
        "left join model_sentences ON model.id = model_sentences.model_id " .
        "left join bundle_product_sentences ON bundle_product.id = bundle_product_sentences.bundle_product_id " .
        "join bundle_details_description bdd on bdd.bundle_product_id = bundle_product.id " .
        "left join product_description_test product_description on (product_description.product_id = product.id) " .
        "left join custom_description cd on cd.bundle_product_id=bundle_product.id and cd.country_id=" . $countryId . " " .
        "where product_description.country_id = " . $countryId . " and product.sku is not null and product.shopsys_id is not null;";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Could not successfully run query from DB: " . mysqli_error($conn);
        exit;
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $product = new Product();
        $lens = new Lens();
        $interLens = new InterLens();

        $product->setAttributeSet($row["attribute_set"]);
        $product->setSku($row["sku"]);
        $product->setModelGroup($row["model_group"]);
        $product->setBundleProductId($row["bundle_product_id"]);
        $product->setGender($row["gender"]);
        $product->setBrand($row["brand"]);
        $product->setBrandLogoUrl($row["brand_logo_url"]);
        $product->setManufacturerSku($row["manufacturer_sku"]);
        $product->setModel($row["model"]);
        $product->setName($row["name"]);
        $product->setFrameShape($row["frame_shape"]);
        $product->setFrameType($row["frame_type"]);
        $product->setFrameShapeUrl($row["frame_shape_url"]);
        $product->setFaceShapeUrl($row["face_shape_url"]);
        $product->setMaterial($row["material"]);
        $product->setJSONTechnologies($row["technologies"]);
        $product->setBrandSentence($row["brand_sentence_" . mb_strtolower($countryCode)]);
        $product->setModelSentence($row["model_sentence_" . mb_strtolower($countryCode)]);
        $product->setBundleProductSentence($row["bundle_sentence_" . mb_strtolower($countryCode)]);
        $lens->setCategory($row["category"]);
        $lens->setVlt($row["vlt"]);
        $lens->setManufacturerLensColor($row["manufacturer_lens_color"]);
        $lens->setConditions($row["lens_conditions"]);
        $lens->setPolarized($row["polarized"]);
        $lens->setPictureUrl($row["lens_url"]);
        $lens->setLensColor($row["lens_color"]);
        $lens->setLensColorUrl($row["lens_color_url"]);
        $lens->setConditionString($row["condition_string"]);
        $product->setLens($lens);
        $interLens->setCategory($row["il_category"]);
        $interLens->setConditions($row["il_lens_conditions"]);
        $interLens->setLensColor($row["il_lens_color"]);
        $interLens->setLensColorUrl($row["il_lens_color_url"]);
        $interLens->setManufacturerLensColor($row["il_man_lens_color"]);
        $interLens->setPictureUrl($row["il_picture_url"]);
        $interLens->setVlt($row["il_vlt"]);
        $interLens->setConditionString($row["il_condition_string"]);
        $product->setInterLens($interLens);
        $product->setPhotochromic($row["photochromic"]);
        $product->setCustomDescription($row["custom_description_" . mb_strtolower($countryCode)]);


        $products[] = $product;
        //echo 'Got product: ' . $product->getSku() . '<br>';
    }

    return $products;
}

function selectTechnologies($conn, $bundleProductId, $countryCode){
    $techs = [];
    $query = "select " .
        "technologies_description." . mb_strtolower($countryCode) . "_name, " .
        "technologies_description." . mb_strtolower($countryCode) . "_text, " .
        "technologies_description.image_url " .
        "from " .
        "bundle_product " .
        "join product_technologies on (product_technologies.bundle_product_id = bundle_product.id) " .
        "join technologies_description on (technologies_description.id = product_technologies.technologies_desc_id) " .
        "where bundle_product.id = " . $bundleProductId . " and in_description = 1";

    $result = mysqli_query($conn, $query);
    $countries = [];

    while ($row = mysqli_fetch_array($result)) {
        $technology = new Technology();
        $technology->setName($row[mb_strtolower($countryCode) . '_name']);
        $technology->setDescription($row[mb_strtolower($countryCode) . '_text']);
        $technology->setUrl($row['image_url']);
        $techs[] = $technology;
    }
    return $techs;
}