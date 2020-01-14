<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_GET['id_notify'])){
            $id_notify=$_GET['id_notify'];
            
            // Xóa các thông báo trong bảng detail_notify
            $stmt=$conn->prepare('DELETE FROM notify_detail WHERE id_notify=:id_notify');
            $check_1=$stmt->execute(array('id_notify'=>$id_notify));

            // Xóa đi thông báo này
            $stmt=$conn->prepare('DELETE FROM notify WHERE id_notify=:id_notify');
            $check_2=$stmt->execute(array('id_notify'=>$id_notify));

            if($check_1 && $check_2){
                header("location:../../../admin.php?action=news&news");
                setcookie("success", "Xóa thông báo thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=news&news");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>