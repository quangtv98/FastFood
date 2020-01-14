<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_GET['id_staff'])){
            $id_staff=$_GET['id_staff'];
            
            // Xóa các tài khoản nhân viên trong bảng staff_per
            $stmt=$conn->prepare('DELETE FROM staff_per WHERE id_staff=:id_staff');
            $check_1=$stmt->execute(array('id_staff'=>$id_staff));

            // Xóa tài khoản nhân viên trong bảng staff
            $stmt=$conn->prepare('DELETE FROM staff WHERE id_staff=:id_staff');
            $check_2=$stmt->execute(array('id_staff'=>$id_staff));

            if($check_1 && $check_2){
                header("location:../../../admin.php?action=account&staff");
                setcookie("success", "Xóa sản phẩm thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=account&staff");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>