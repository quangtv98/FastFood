<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        foreach($_POST['qty'] as $id_pro => $value) { 
            $value=abs($value);
            $_SESSION['cart'][$id_pro]['qty']=$value; 

            // Cập nhật lại số lượng khi cập nhật giỏ hàng
            if(isset($_SESSION['id_user'])){
                $qty=$_SESSION['cart'][$id_pro]['qty'];
                $id_user=$_SESSION['id_user'];
                $stmt=$conn->prepare('UPDATE cart SET qty=:qty WHERE id_pro=:id_pro AND id_user=:id_user');
                $stmt->execute(['qty' => $qty, 'id_pro' => $id_pro, 'id_user' => $id_user]);
            }
            header("location:../../../index.php?page=cart");
            setcookie("success", "Đã cập nhật lại thành công !!!", time()+1,"/","",0);
        }
    }
?>