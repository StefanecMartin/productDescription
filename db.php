<?php
define('HOST', '10.80.48.52');
define('USER', 'onix');
define('PASS', 'Yezu4FdAQicOwmwq3TAQ');
define('DB', 'onix');


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

function closeConn($conn){
    mysqli_close($conn);
}


function selectCountries($conn)
{
    $result = mysqli_query($conn, 'select distinct country_id, country.code from product_description_test product_description join country on product_description.country_id = country.id where country.is_active = 1;');
    $map = array();
    while ($row = mysqli_fetch_array($result)) {
        if ($row['code'] === "INT") {
            $map['EN'] = $row['country_id'];
        }
        $map[$row['code']] = $row['country_id'];
    }
    //print_r($map);
    return $map;
}

function createHelpTables($conn, $countryCode){
    $query1 = "create table lens_conditions_description AS " .
        "select l.id as lens_id, if(group_concat(c.id SEPARATOR ',') = '1,2,3,4', SUBSTRING_INDEX(SUBSTRING_INDEX(group_concat(c.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '),' / ',4),' / ',-1) ,group_concat(c.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '))  as lens_conditions, " .
        "if(group_concat(c.id SEPARATOR ',') = '1,2,3,4', SUBSTRING_INDEX(SUBSTRING_INDEX(group_concat(c2.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '),' / ',4),' / ',-1) ,group_concat(c2.conditions_" . mb_strtolower($countryCode) . " SEPARATOR ' / '))  as condition_string " .
        "FROM lens l " .
        "join lens_conditions ON l.id = lens_conditions.lens_id " .
        "join conditions c2 ON lens_conditions.conditions_id = c2.id " .
        "join conditions_description c ON lens_conditions.conditions_id = c.id " .
        "GROUP BY l.id;";
    echo $query1;
    echo '<br><br>';

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
    echo $query2;
    echo '<br><br>';

    $query3 = "alter table lens_conditions_description add FOREIGN KEY (lens_id) REFERENCES lens (id);";
    echo $query3;
    echo '<br><br>';

    $query4 = "alter table bundle_details_description add FOREIGN KEY (bundle_product_id) REFERENCES bundle_product (id);";
    echo $query4;
    echo '<br><br>';

    $query5 = "drop table if exists lens_conditions_description;";
    echo $query5;
    echo '<br><br>';

    $query6 = "drop table if exists bundle_details_description;";
    echo $query6;
    echo '<br><br>';
}

