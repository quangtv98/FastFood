<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){

            $id_bill=$_GET['id_bill'];
            $status=addslashes($_POST['status']);

            $stmt=$conn->prepare('UPDATE bill SET status=:status WHERE id_bill=:id_bill');
            $check=$stmt->execute(['status'=>$status, 'id_bill'=>$id_bill]);

            // Đối với hóa đơn giao xong phải cập nhật thời gian giao
            if($status==4){

                // Lấy ra thời gian giao hoàn tất
                $current_datetime=current_datetime();
                $updated_at=$current_datetime['updated_at_datetime'];
                // Cập nhật thời gian giao
                $stmt=$conn->prepare('UPDATE bill SET updated_at=:updated_at WHERE id_bill=:id_bill');
                $stmt->execute(['updated_at'=>$updated_at, 'id_bill'=>$id_bill]);
            }

            if($check){
                header("location:../../../admin.php?action=bill");
                setcookie("success", "Đã cập nhật hóa đơn thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=bill");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>