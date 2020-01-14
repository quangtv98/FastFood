<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_GET['id_notify'])){
            $id_staff=$_SESSION['id_staff'];
            $id_notify=$_GET['id_notify'];
            //Đánh dấu là đã đọc thông báo
            $stmt=$conn->prepare('UPDATE notify_staff SET status=:status WHERE id_notify=:id_notify AND id_staff=:id_staff');
            $check=$stmt->execute(['status'=>1, 'id_notify'=>$id_notify, 'id_staff'=>$id_staff]);

            if($check){
                header("location:../../../admin.php?action=notify");
            }
            else{
                header("location:../../../admin.php?action=notify");
                setcookie("error", "có lỗi xảy ra trong qúa trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>