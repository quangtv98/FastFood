<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_bill'])){
        $id_bill=$_GET['id_bill'];
        
        // Xóa các đơn hàng trong đơn giao
        $stmt=$conn->prepare('DELETE FROM delivery WHERE id_bill=:id_bill');
        $check_1=$stmt->execute(array('id_bill'=>$id_bill));

        // Xóa các đơn hàng trong chi tiết đơn hàng
        $stmt=$conn->prepare('DELETE FROM bill_detail WHERE id_bill=:id_bill');
        $check_2=$stmt->execute(array('id_bill'=>$id_bill));

        // Xóa các đơn hàng 
        $stmt=$conn->prepare('DELETE FROM bill WHERE id_bill=:id_bill');
        $check_3=$stmt->execute(array('id_bill'=>$id_bill));

        if($check_1 && $check_2 && $check_3){
            header("location:../../../admin.php?action=bill&bill");
            setcookie("success", "Xóa đơn hàng thành công !!!", time()+1,"/","",0);
        }
        else{
            header("location:../../../admin.php?action=bill&bill");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../admin.php?action=bill&bill");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!! !!!", time()+1,"/","",0);
    }
?>