<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_type']) && isset($_GET['status'])){
        $id_type=$_GET['id_type'];
        $status=$_GET['status'];
        if($status == 0){
            // Mở bán loại sản phẩm này
            $stmt=$conn->prepare('UPDATE product_type SET status=:status WHERE id_type=:id_type');
            $stmt->bindParam(':id_type', $id_type);
            $stmt->bindParam(':status', $status);
            $status=1;
        }else{
            //Ngưng bán sản phẩm thuộc loại này
            $stmt=$conn->prepare('UPDATE product SET status="0" WHERE id_type=:id_type');
            $stmt->execute(['id_type' => $id_type]);

            //Ngưng bán loại sản phẩm này
            $stmt=$conn->prepare('UPDATE product_type SET status=:status WHERE id_type=:id_type');
            $stmt->bindParam(':id_type', $id_type);
            $stmt->bindParam(':status', $status);
            $status=0;
        }

        $check=$stmt->execute();

        if($check){
            header("location:../../../admin.php?action=product&type_pro");
            if($status == 0){
                setcookie("success", "Đã ngưng bán loại sản phẩm này !!!", time()+1,"/","",0);
            }else{
                setcookie("success", "Đã mở loại bán sản phẩm này !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../admin.php?action=product&type_pro");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>