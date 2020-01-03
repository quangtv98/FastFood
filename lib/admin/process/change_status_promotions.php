<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_promo']) && isset($_GET['status'])){
        $id_promo=$_GET['id_promo'];
        $status=$_GET['status'];
        if($status == 0){
            // Kết thúc tất cả để bắt đầu chương trình mới
            $stmt=$conn->prepare('UPDATE promotions SET status="2" WHERE status="1"');
            $stmt->execute();
            // Bắt đầu chương trình khuyến mãi
            $stmt=$conn->prepare('UPDATE promotions SET status=:status WHERE id_promo=:id_promo');
            $stmt->bindParam(':id_promo', $id_promo);
            $stmt->bindParam(':status', $status);
            $status=1;
        }else if($status == 1){
            // Kết thúc chương trình khuyến mãi
            $stmt=$conn->prepare('UPDATE promotions SET status=:status WHERE id_promo=:id_promo');
            $stmt->bindParam(':id_promo', $id_promo);
            $stmt->bindParam(':status', $status);
            $status=2;
        }

        $check=$stmt->execute();

        if($check){
            header("location:../../../admin.php?action=promotions&promotions");
            if($status == 1){
                setcookie("success", "Đã bắt đầu chương trình khuyến mãi !!!", time()+1,"/","",0);
            }else if($status == 2){
                setcookie("success", "Đã kết thúc chương trình khuyến mãi !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../admin.php?action=promotions&promotions");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../admin.php?action=promotions&promotions");
        setcookie("error", "có lỗi xảy ra trong qua trình xử lý !!!", time()+1,"/","",0);
    }
?>