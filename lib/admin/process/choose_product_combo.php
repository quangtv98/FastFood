<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        if(count($_POST['choose']) >= 2){
            foreach($_POST['choose'] as $key => $id_pro){
                $_SESSION['choose'][$id_pro]=array('qty' => 1);
            }
        }else if(count($_POST['choose']) == 0){
            setcookie("warning", "Bạn chưa chọn sản phẩm vào combo !!!", time()+1,"/","",0);
        }
        header("location:../../../admin.php?action=product&add_combo");
    }
    else{
        header("location:../../../admin.php?action=product&add_combo");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>