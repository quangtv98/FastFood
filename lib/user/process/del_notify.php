<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_GET['id_notify'])){
            $id_user=$_SESSION['id_user'];
            $id_notify=$_GET['id_notify'];

            // Xóa thông báo trong bảng notify_detail
            $stmt=$conn->prepare('DELETE FROM notify_detail WHERE id_notify=:id_notify AND id_user=:id_user');
            $check=$stmt->execute(['id_notify'=>$id_notify, 'id_user'=>$id_user]);

            if($check){
                header("location:../../../index.php?page=notify");
                setcookie("success", "Xóa thông báo thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../index.php?page=notify");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "tài khoản không tồn tại !!!", time()+1,"/","",0);
    }
?>