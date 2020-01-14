<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){

            $ship = addslashes($_POST['ship']);
            if(isset($_GET['id_ship'])){
                $id_ship=$_GET['id_ship'];
                // Đưa phí ship hiện tại về trạng thái không kích hoạt
                $stmt=$conn->prepare('UPDATE ship SET status=:status WHERE id_ship=:id_ship');
                $check=$stmt->execute(['status'=>'0', 'id_ship'=>$id_ship]);
            }

            // Cập nhật phí vận chuyển mới nhưng không xóa phí cũ
            $stmt=$conn->prepare('INSERT INTO ship (ship) VALUES (:ship)');
            $check=$stmt->execute(['ship'=>$ship]);

            if($check){
                header("location:../../../admin.php?action=promotions&upd_ship");
                setcookie("success", "Cập nhật phí ship thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=promotions&upd_ship");
                setcookie("error", "Cập nhật phí ship thất bại !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>