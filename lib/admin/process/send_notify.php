<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            $title = addslashes($_POST['title']);
            $message = addslashes($_POST['message']);
            $type_receiver = addslashes($_POST['type_receiver']);
            $current_datetime = current_datetime();
            $date_send = $current_datetime['created_at_date'];
            $_SESSION['title'] = $title;
            $_SESSION['message'] = $message;

            // INSERT vào bảng chính
            $stmt=$conn->prepare('INSERT INTO notify(type_receiver, title, message, date_send) VALUE (:type_receiver, :title, :message, :date_send)');
            $check = $stmt->execute([':type_receiver'=>$type_receiver, ':title'=>$title, ':message'=>$message, ':date_send'=>$date_send]);
            if($check){
                $id_notify = $conn->lastInsertId();

                // INSERT vào bảng với người nhận là khách hàng 
                if($type_receiver == 1){
                    $stmt=$conn->prepare('SELECT id_user FROM user WHERE status="1"');  
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $id_user = $row['id_user'];
                        $stmt=$conn->prepare('INSERT INTO notify_user(id_notify, id_user) VALUE (:id_notify, :id_user)');
                        $stmt->execute([':id_notify'=>$id_notify, ':id_user'=>$id_user]);
                    }
                }
                // INSERT vào bảng với người nhận là nhân viên
                else if($type_receiver == 2){
                    $stmt=$conn->prepare('SELECT id_staff FROM staff WHERE status="1"');
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $id_staff = $row['id_staff'];
                        $stmt=$conn->prepare('INSERT INTO notify_staff(id_notify, id_staff) VALUE (:id_notify, :id_staff)');
                        $stmt->execute([':id_notify'=>$id_notify, ':id_staff'=>$id_staff]);
                    }  
                }
                // INSERT vào bảng với người nhận là toàn bộ hệ thống
                else{
                    // INSERT vào bảng với người nhận là khách hàng 
                    $stmt=$conn->prepare('SELECT id_user FROM user WHERE status="1"');  
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $id_user = $row['id_user'];
                        $stmt=$conn->prepare('INSERT INTO notify_user(id_notify, id_user) VALUE (:id_notify, :id_user)');
                        $stmt->execute([':id_notify'=>$id_notify, ':id_user'=>$id_user]);
                    }
                    // INSERT vào bảng với người nhận là nhân viên
                    $stmt=$conn->prepare('SELECT id_staff FROM staff WHERE status="1"');
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row){
                        $id_staff = $row['id_staff'];
                        $stmt=$conn->prepare('INSERT INTO notify_staff(id_notify, id_staff) VALUE (:id_notify, :id_staff)');
                        $stmt->execute([':id_notify'=>$id_notify, ':id_staff'=>$id_staff]);
                    } 
                }
                unset($_SESSION['title']);
                unset($_SESSION['message']);
                header("location:../../../admin.php?action=news&news");
                setcookie("success", "Gửi thông báo thành công !!!", time()+1,"/","",0);
            }else{
                header("location:../../../admin.php?action=news&send");
                setcookie("error", "Gửi thông báo thất bại !!!", time()+1,"/","",0);
            }
        }    
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>