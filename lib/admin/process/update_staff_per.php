<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_POST['submit'])){
        unset($_SESSION['permission']);
        $id_staff=$_GET['id_staff'];
        $licensed=$_GET['licensed'];

        $query="DELETE FROM staff_per WHERE id_staff=:id_staff";
        $stmt=$conn->prepare($query);
        $stmt->execute(['id_staff'=>$id_staff]);

            
        // Cập nhật chức vụ nhân viên
        foreach ($_POST['id_per'] as $id_per) {
            $stmt=$conn->prepare('INSERT INTO staff_per (id_staff, id_per, licensed) VALUE (:id_staff, :id_per, :licensed)');
            $check=$stmt->execute(['id_staff'=>$id_staff, 'id_per'=>$id_per, 'licensed'=>$licensed]);
        }

        if($check){
            header("location:../../../admin.php?action=account&staff");
            setcookie("success", "Cập nhật chức vụ của nhân viên thành công !!!", time()+1,"/","",0);
        }
        else{
            header("location:../../../admin.php?action=account&staff");
            setcookie("error", "Cập nhật chức vụ thất bại !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../admin.php?action=account&staff");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>