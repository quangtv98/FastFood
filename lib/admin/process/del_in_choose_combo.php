<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_pro'])){
        $id_pro=$_GET['id_pro'];
        if(count($_SESSION['choose']) > 1){
            unset($_SESSION['choose'][$id_pro]);
        }
        else{
            unset($_SESSION['choose']);
        }

        header("location:../../../admin.php?action=product&add_combo");
    }else{
        header("location:../../../admin.php?action=product&add_combo");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>