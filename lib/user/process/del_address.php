<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_GET['id_address'])){
            $id_user=$_SESSION['id_user'];
            $id_address=$_GET['id_address'];
            $page=$_GET['page'];

            // Xóa địac chỉ trong bảng address
            $stmt=$conn->prepare('DELETE FROM address WHERE id_address=:id_address AND id_user=:id_user');
            $check=$stmt->execute(['id_address'=>$id_address, 'id_user' => $id_user]);

            if($check){
                if($page == "payment"){
                    // Chuyển về trang thanh toán nếu hành động xóa được thực hiện ở trang thanh toán
                    header("location:../../../index.php?page=payment");
                }else if($page == "address"){
                    // Chuyển về trang thanh toán nếu hành động xóa được thực hiện ở trang cá nhân
                    header("location:../../../index.php?page=address");
                }
                setcookie("success", "Xóa địa chỉ thành công !!!", time()+1,"/","",0);
            }
            else{
                if($page == "payment"){
                    // Chuyển về trang thanh toán nếu hành động xóa được thực hiện ở trang thanh toán
                    header("location:../../../index.php?page=payment");
                }else if($page == "address"){
                    // Chuyển về trang thanh toán nếu hành động xóa được thực hiện ở trang cá nhân
                    header("location:../../../index.php?page=address");
                }
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>