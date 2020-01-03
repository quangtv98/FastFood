<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_user']) && isset($_GET['status'])){
        $id_user=$_GET['id_user'];
        $status=$_GET['status'];
        if($status == 0){
            // Kích hoạt tài khoản
            $stmt=$conn->prepare('UPDATE user SET status=:status WHERE id_user=:id_user');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_user', $id_user);
            $status=1;
        }else{
            // Hủy kích hoạt tài khoản
            $stmt=$conn->prepare('UPDATE user SET status=:status WHERE id_user=:id_user');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_user', $id_user);
            $status=0;
        }
        
        $check=$stmt->execute();

        if($check){
            header("location:../../../admin.php?action=account&user");
            if($status == 0){
                setcookie("success", "Đã hủy kích hoạt tài khoản !!!", time()+1,"/","",0);
            }else{
                setcookie("success", "Đã kích hoạt tài khoản !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../admin.php?action=account&user");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../admin.php?action=account&user");
        setcookie("error", "có lỗi xảy ra trong qua trình xử lý !!!", time()+1,"/","",0);
    }
?>