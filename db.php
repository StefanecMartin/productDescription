<?php
define('HOST','10.80.48.52');
define('USER','onix');
define('PASS','Yezu4FdAQicOwmwq3TAQ');
define('DB','onix');


function getConn(){
    $conn = mysqli_connect(HOST,USER,PASS,DB);
    if ($conn){
        echo 'SUCCESS<br>';
        #$result = mysqli_query($conn,'SELECT * FROM brand');
        #$row = mysqli_fetch_row($result);
        #$message=$row[1];
        return $conn;
    }else{
        echo 'NO CONNECTION<br>';
        return null;
    }
}

