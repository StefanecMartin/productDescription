<?php
include "./db.php";


$onix=getConn();

$countries = selectCountries($onix);

//add foreach countries
createHelpTables($onix,key($countries));

$products = selectProductData($onix, key($countries), $countries[key($countries)]);



dropHelpTables($onix);










closeConn($onix);
?>