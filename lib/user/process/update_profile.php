<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_POST['submit'])){
            $id_user=$_SESSION['id_user'];
            $username=trim(addslashes($_POST['username']));
            
            $stmt=$conn->prepare('UPDATE user SET username=:username WHERE id_user=:id_user');
            $check=$stmt->execute(array('username'=>$username, 'id_user'=>$id_user));

            if($check){
                $_SESSION['username']=$username;
                header("location:../../../index.php?page=profile");
                setcookie("success", "Thay đổi thông tin thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../index.php?page=profile");
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }                   
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>