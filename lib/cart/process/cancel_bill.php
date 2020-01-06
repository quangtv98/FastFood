<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_user'])){
        //Cập nhập thành trạng thái hủy đơn hàng
        $id_user=$_SESSION['id_user'];
        $id_bill=$_GET['id_bill'];
        $query="UPDATE bill SET status=:status WHERE id_user=:id_user AND id_bill=:id_bill";
        $stmt=$conn->prepare($query);
        $check=$stmt->execute(array('status' => '1','id_user' => $id_user, 'id_bill' => $id_bill));
        if($check){
            header("location:../../../index.php?page=view_bill_detail&id_bill=$id_bill");
            setcookie("success", "Hủy đơn hàng thành công !!!", time()+1,"/","",0);
        }
        else{
            header("location:../../../index.php?page=view_bill_detail&id_bill=$id_bill");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php?page=view_bill_detail&id_bill=$id_bill");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>