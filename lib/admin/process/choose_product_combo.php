<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            if(count($_POST['choose']) >= 2){
                foreach($_POST['choose'] as $key => $id_pro){
                    $_SESSION['choose'][$id_pro]=array('qty' => 1);
                }
            }else{
                setcookie("warning", "Combo phải có trên 2 sản phẩm !!!", time()+1,"/","",0);
            }
            header("location:../../../admin.php?action=product&add_combo");
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>