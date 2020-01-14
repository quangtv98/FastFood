<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            $id_notify=$_GET['id_notify'];
            $title = addslashes($_POST['title']);
            $message = addslashes($_POST['message']);
            $current_datetime = current_datetime();
            $date_send = $current_datetime['created_at_date'];

            // Cập nhật thông báo
            $query="UPDATE notify SET title=:title, message=:message, date_send=:date_send WHERE id_notify=:id_notify";
            $stmt=$conn->prepare($query);
            $data=array('title'=>$title, 'message'=>$message, 'id_notify'=>$id_notify, 'date_send'=> $date_send);
            $check=$stmt->execute($data);

            if($check ){
                header("location:../../../admin.php?action=news&news");
                setcookie("success", "Cập nhật thông báo thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=news&news");
                setcookie("error", "Cập nhật thông báo thất bại !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>