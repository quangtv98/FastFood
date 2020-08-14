<?php

    $host     = "d9c88q3e09w6fdb2.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    $username = "jxu1iwsjkwyds812";
    $password = "rn8aj56rd3wmeema";
    $dbname   = "j3eifrxpdhajx29h";
    try{
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
    }
    catch(PDOException $e){
        echo "Lỗi kết nối đến server !!!".$e->getMessage();
    }
?>
<?php
/*
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fastfood";
    try{
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
    }
    catch(PDOException $e){
        echo "Lỗi kết nối đến server !!!".$e->getMessage();
    }
*/?>