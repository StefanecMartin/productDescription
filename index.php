<html lang="en-us">
<body>
<h1 align="center" style = "font-size: 50px; font-weight: bolder;"> DESCRIPTION MASTER PROFESIONAL</h1>
<?php
include "./db.php";
$onix = getConn();

$countries = selectCountries($onix);
echo 'test';
?>
<form action="generate.php" method="post">
    <div>
        <label for="country">Generate description for:</label>
        <select name="country" id="country">
            <option value="all"> All </option>
            <?php
            foreach ($countries as $c){
                echo '<option value=' . $c->getCode() . '>' . $c->getCode() . '</option>';
            }
            ?>
        </select>
    </div>
    <div>
        <button type="submit">Confirm</button>
    </div>
</form>

</body>
</html>