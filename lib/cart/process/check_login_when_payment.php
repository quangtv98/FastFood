<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_user'])){
        header("location:../../../index.php?page=delivery_address");
    }else{
        header("location:../../../index.php?page=signin&action=delivery_address");
        setcookie("error", "Bạn phải đăng nhập để thanh toán !!!", time()+1,"/","",0);
    }
?>