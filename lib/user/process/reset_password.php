<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $new_pass = addslashes($_POST['new_pass']);
        $re_new_pass = addslashes($_POST['re_new_pass']);

        //kiểm tra password có khớp không ?
        if($new_pass != $re_new_pass){
            header("location:../../../index.php?page=signin&id_authentic");
            setcookie("error", "Mật khẩu mới không khớp !!!", time()+1,"/","",0);
        }
        else{
            $new_pass=md5($new_pass);
            $current_datetime=current_datetime();
            $created_at=$current_datetime['created_at_datetime'];
            $id_user=$_COOKIE['id_authentic'];

            $stmt=$conn->prepare('UPDATE user SET password=:password, created_at=:created_at WHERE id_user=:id_user');
            $data=array('password'=>$new_pass, 'created_at' => $created_at, 'id_user' => $id_user);
            $check=$stmt->execute($data);

            if($check){
                $stmt=$conn->prepare('SELECT username FROM user WHERE id_user=:id_user');
                $stmt->execute(['id_user' => $id_user]);
                $row=$stmt->fetch();
                
                $_SESSION['id_user']=$id_user;
                $_SESSION['username']=$row['username'];
                setcookie("id_authentic", $id_user, time()-3600,"/","",0);
                setcookie("success", "Quá trình xác nhận hoàn tất !!!", time()+1,"/","",0);
                header("location:../../../index.php");
            }
            else{
                header("location:../../../index.php?page=signin&id_authentic");
                setcookie("error", "Có lỗi xảy ra trong quá trình đăng ký !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Có lỗi xảy ra trong quá trình đăng ký !!!", time()+1,"/","",0);
    }
?>