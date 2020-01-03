<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        if(isset($_SESSION['id_user'])){
            $id_user = $_SESSION['id_user'];
            $id_address = $_POST['id_address'];

            // Set status trở về 0
            $stmt = $conn->prepare('UPDATE address SET status=:status');
            $check = $stmt->execute(['status' => 0]);
            // var_dump($id_address,$check); exit();

            // Chọn lại địa chỉ mặc định
            $stmt = $conn->prepare('UPDATE address SET status=:status WHERE id_address=:id_address');
            $check = $stmt->execute(['status' => 1, 'id_address' => $id_address]);
            if($check){
                header("location:../../../index.php?page=profile");
                setcookie("success", "Đã chọn lại địa chỉ mặc định !!!", time()+1,"/","",0);
            }else{
                header("location:../../../index.php?page=profile");
                setcookie("error", "Chọn lại địa chỉ mặc định thất bại !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>