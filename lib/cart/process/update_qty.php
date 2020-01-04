<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        foreach($_POST['qty'] as $id_pro => $qty) { 
            $_SESSION['cart'][$id_pro]['qty']=$qty;

            // Cập nhật lại số lượng khi cập nhật giỏ hàng
            if(isset($_SESSION['id_user'])){
                $id_user=$_SESSION['id_user'];
                $stmt=$conn->prepare('UPDATE cart SET qty=:qty WHERE id_user=:id_user AND id_pro=:id_pro');
                $stmt->execute(['qty' => $qty, 'id_user' => $id_user, 'id_pro' => $id_pro]);
            }
        }
        header("location:../../../index.php?page=cart");
    }
?>