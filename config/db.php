<?php 
    $host = "localhost";
    $dbname = "wisdom_shop";
    $nickdb = "root";
    $pw = "";

    $conn = new mysqli($host, $nickdb, $pw, $dbname);

    if ($conn-> connect_error){
        die("Connection database failed".$conn->connect_error);
    }
?>