<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_GET['id_address'])){
            $_SESSION['id_address'] = $_GET['id_address'];
            header("location:../../../index.php?page=payment");
        }
        else{
            header("location:../../../index.php?page=delivery_address");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>