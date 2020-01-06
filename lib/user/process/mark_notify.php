<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_user']) && isset($_GET['id_notify'])){
        $id_user=$_SESSION['id_user'];
        $id_notify=$_GET['id_notify'];
        //Đánh dấu là đã đọc thông báo
        $stmt=$conn->prepare('UPDATE notify_user SET status=:status WHERE id_notify=:id_notify AND id_user=:id_user');
        $check=$stmt->execute(['status'=>1, 'id_notify'=>$id_notify, 'id_user'=>$id_user]);

        if($check){
            header("location:../../../index.php?page=notify");
        }
        else{
            header("location:../../../index.php?page=notify");
            setcookie("error", "có lỗi xảy ra trong qúa trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>