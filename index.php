<?php
include "./db.php";


$onix=getConn();

$countries = selectCountries($onix);

foreach ($countries as $country){
    createHelpTables($onix,$country->getCode());

   $products = selectProductData($onix, $country->getCode(), $country->getId());
   echo 'Product list completed for country '. $country->getCode() . '!<br>';

   $descFile = fopen("./DESC/DESC-" . date("Y-m-d-H-i-s") . "__" . $country->getCode() .".csv", "w") or die('Unable to open file');
   fwrite($descFile, 'sku,description_'.$country->getShopsysCode()."\n");
   fwrite($descFile,'test');
   fclose($descFile);
   dropHelpTables($onix);

}









closeConn($onix);
?>