<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_SESSION['id_staff']) && isset($_GET['id_notify'])){
            $id_staff=$_SESSION['id_staff'];
            $id_notify=$_GET['id_notify'];

            // Xóa thông báo trong bảng notify_detail
            $stmt=$conn->prepare('DELETE FROM notify_detail WHERE id_notify=:id_notify AND id_staff=:id_staff');
            $check=$stmt->execute(['id_notify'=>$id_notify, 'id_staff'=>$id_staff]);

            if($check){
                header("location:../../../admin.php?action=notify");
                setcookie("success", "Xóa thông báo thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=notify");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>