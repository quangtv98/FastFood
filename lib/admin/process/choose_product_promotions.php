<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            if(count($_POST['choose']) >= 1){
                foreach($_POST['choose'] as $key => $id_pro){
                    // Không chọn giá trước
                    $_SESSION['choose_pro_in_promotion'][$id_pro]=array('reduced_price' => "");
                }
            }else{
                setcookie("warning", "Hãy chọn sản phẩm tham gia chương trình khuyến mãi !!!", time()+1,"/","",0);
            }
            header("location:../../../admin.php?action=promotions&act");
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>