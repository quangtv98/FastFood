<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_GET['id_pro'])){
            $id_pro=$_GET['id_pro'];
            if(count($_SESSION['choose_pro_in_promotion']) > 1){
                unset($_SESSION['choose_pro_in_promotion'][$id_pro]);
            }
            else{
                unset($_SESSION['choose_pro_in_promotion']);
            }
            header("location:../../../admin.php?action=promotions&act");
        }    
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>