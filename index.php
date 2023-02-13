<?php
include "./db.php";


$onix=getConn();

$countries = selectCountries($onix);

createHelpTables($onix,key($countries));












closeConn($onix);
?>