<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_GET['id_address'])){
            $id_user = $_SESSION['id_user'];
            $id_address = $_GET['id_address'];

            // Set status trở về 0
            $stmt = $conn->prepare('UPDATE address SET status=:status WHERE id_user=:id_user');
            $check = $stmt->execute(['status' => 0, 'id_user' => $id_user]);

            // Chọn lại địa chỉ mặc định
            $stmt = $conn->prepare('UPDATE address SET status=:status WHERE id_address=:id_address AND id_user=:id_user');
            $check = $stmt->execute(['status' => 1, 'id_address' => $id_address, 'id_user' => $id_user]);
            if($check){
                header("location:../../../index.php?page=address");
                setcookie("success", "Đã chọn lại địa chỉ mặc định !!!", time()+1,"/","",0);
            }else{
                header("location:../../../index.php?page=address");
                setcookie("error", "Chọn lại địa chỉ mặc định thất bại !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>