<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_GET['id_notify'])){
            $id_notify=$_GET['id_notify'];
            $type_receiver=$_GET['type_receiver'];
            
            if($type_receiver == 1){
                // Xóa các thông báo trong bảng notify
                $stmt=$conn->prepare('DELETE FROM notify WHERE id_notify=:id_notify');
                $check=$stmt->execute(array('id_notify'=>$id_notify));
                
                // Xóa các thông báo trong bảng notify_user
                $stmt=$conn->prepare('DELETE FROM notify_user WHERE id_notify=:id_notify');
                $stmt->execute(array('id_notify'=>$id_notify));
            }else if($type_receiver == 2){
                // Xóa các thông báo trong bảng notify
                $stmt=$conn->prepare('DELETE FROM notify WHERE id_notify=:id_notify');
                $check=$stmt->execute(array('id_notify'=>$id_notify));
                
                // Xóa các thông báo trong bảng notify_staff
                $stmt=$conn->prepare('DELETE FROM notify_staff WHERE id_notify=:id_notify');
                $stmt->execute(array('id_notify'=>$id_notify));
            }else{
                // Xóa các thông báo trong bảng notify
                $stmt=$conn->prepare('DELETE FROM notify WHERE id_notify=:id_notify');
                $check=$stmt->execute(array('id_notify'=>$id_notify));
                
                // Xóa các thông báo trong bảng notify_user
                $stmt=$conn->prepare('DELETE FROM notify_user WHERE id_notify=:id_notify');
                $stmt->execute(array('id_notify'=>$id_notify));

                // Xóa các thông báo trong bảng notify_staff
                $stmt=$conn->prepare('DELETE FROM notify_staff WHERE id_notify=:id_notify');
                $stmt->execute(array('id_notify'=>$id_notify));
            }

            if($check){
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                    header("location:../../../admin.php?action=news&news&page=$page");
                }else{
                    header("location:../../../admin.php?action=news&news");
                }
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