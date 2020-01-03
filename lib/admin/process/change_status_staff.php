<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_staff']) && isset($_GET['status'])){
        $id_staff=$_GET['id_staff'];
        $status=$_GET['status'];
        if($status == 0){
            // Kích hoạt tài khoản
            $stmt=$conn->prepare('UPDATE staff SET status="1" WHERE id_staff=:id_staff');
            $stmt->bindParam(':id_staff', $id_staff);
            $stmt_s=$conn->prepare('UPDATE staff_per SET licensed="1" WHERE id_staff=:id_staff');
            $stmt_s->bindParam(':id_staff', $id_staff);
        }else{
            // Hủy kích hoạt tài khoản
            $stmt=$conn->prepare('UPDATE staff SET status="0" WHERE id_staff=:id_staff');
            $stmt->bindParam(':id_staff', $id_staff);
            $stmt_s=$conn->prepare('UPDATE staff_per SET licensed="0" WHERE id_staff=:id_staff');
            $stmt_s->bindParam(':id_staff', $id_staff);
        }
        
        $check_1=$stmt->execute();
        $check_2=$stmt_s->execute();

        if($check_1 && $check_2){
            header("location:../../../admin.php?action=account&staff");
            if($status == 0){
                setcookie("success", "Đã kích hoạt tài khoản !!!", time()+1,"/","",0);
            }else{
                setcookie("success", "Đã hủy kích hoạt tài khoản !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../admin.php?action=account&staff");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../admin.php?action=account&staff");
        setcookie("error", "có lỗi xảy ra trong qua trình xử lý !!!", time()+1,"/","",0);
    }
?>