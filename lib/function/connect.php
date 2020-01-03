<?php
    // $host = "ec2-174-129-41-127.compute-1.amazonaws.com";
    // $username = "bkpflgacsflhnj";
    // $password = "717d981b62494b22548153d4f625021b6b6d09290993133528402109e74d8c7a";
    // $dbname="d61ledlnrujbs6";
    // try{
    //     $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $conn->exec("set names utf8");
    // }
    // catch(PDOException $e){
    //     echo "Lỗi kết nối đến server !!!".$e->getMessage();
    // }
?>
<?php
    // //goi namespace
    // use MongoDB\Client;

    // //require autoload
    // require_once "vendor/autoload.php";

    // // khoi tao class Client
    // $conn = new Client("mongodb://127.0.0.1:27017");

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
?>