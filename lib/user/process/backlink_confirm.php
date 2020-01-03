<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_COOKIE['id_authentic']) && isset($_GET['token'])){
        $id_user=$_COOKIE['id_authentic'];
        $token=$_GET['token'];
        $token.="7nWZLcCK0vsPzIM";
        $token=md5($token);

        $stmt=$conn->prepare('SELECT token FROM user WHERE id_user=:id_user');
        $check=$stmt->execute(['id_user'=>$id_user]);
        $row=$stmt->fetch();
        $token_db=$row['token'];
        if($token == $token_db){
            setcookie("success", "Vui lòng xác nhận lại mật khẩu mới !!!", time()+1,"/","",0);
            header("location:../../../index.php?page=signin&id_authentic");
        }
        else{
            setcookie("error", "Đường dẫn xác nhận không đúng !!!", time()+1,"/","",0);
            header("location:../../../index.php?page=signin");
        } 
    }
    else{
        setcookie("error", "Xin lỗi !!! Đã hết hạn xác nhận !!!", time()+1,"/","",0);
        header("location:../../../index.php?page=signin");
    }
?>