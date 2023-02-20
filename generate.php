<html>
<body>

<button onclick="window.location.href='index.php';">
    Back
</button>
<br>

<?php
include "./db.php";
include "./description.php";
include "./Entity/Styles.php";

ob_end_flush();
ob_implicit_flush();

$onix = getConn();

$country = selectCountry($onix, $_POST["country"]);
$style = new Styles();
$date = date("Y-m-d-H-i-s");


createHelpTables($onix, $country->getCode());

$products = selectProductData($onix, $country->getCode(), $country->getId());
echo 'Products selected for country ' . $country->getCode() . '!<br>';

$descFile = fopen("./DESC/DESC-" . $date . "__" . $country->getCode() . ".csv", "w") or die('Unable to open file');
fwrite($descFile, "\"sku\",\"description_" . $country->getShopsysCode() . "\"\n");

foreach ($products as $product) {
    $desc = description($onix, $product, $country->getCode(), $style);
    fwrite($descFile, "\"" . $product->getSku() . "\",\"" . str_replace("\"", "\"\"", $desc) . "\"\n");
    //echo 'Product ' . $product->getSku() . ' written.<br>';
}

echo 'Description generated for country ' . $country->getCode() . '!<br>';
fclose($descFile);
dropHelpTables($onix);


echo 'Finished';
closeConn($onix);
?>

</body>
</html>
