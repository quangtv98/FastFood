<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_user'])){
        if(isset($_POST['submit'])){
            $id_user=$_SESSION['id_user'];
            $password_old=addslashes($_POST['password_old']);
            $_SESSION['password_old']=$password_old;
            $password_old=md5($password_old);

            $password_new=addslashes($_POST['password_new']);
            $_SESSION['password_new']=$password_new;
            $password_new=md5($password_new);

            $re_password_new=addslashes($_POST['re_password_new']);
            $_SESSION['re_password_new']=$re_password_new;
            $re_password_new=md5($re_password_new);
            
            $query="SELECT password FROM user WHERE id_user=:id_user";
            $stmt=$conn->prepare($query);
            $stmt->execute(array('id_user'=>$id_user));
            $row=$stmt->fetch();
            $password=$row['password'];
            if($password==$password_old){
                if($password_new==$re_password_new){
                    if($password==$password_new){
                        header("location:../../../index.php?page=profile");
                        setcookie("error", "Mật khẩu mới trùng với mật khẩu cũ !!!", time()+1,"/","",0);
                    }
                    else{
                        $stmt=$conn->prepare('UPDATE user SET password=:password_new WHERE id_user=:id_user');
                        $data=array('password_new'=>$password_new, 'id_user'=>$id_user);
                        $check=$stmt->execute($data);
                        if($check){
                            unset($_SESSION['password_old']);
                            unset($_SESSION['password_new']);
                            unset($_SESSION['re_password_new']);
                            if(isset($_SESSION['error'])){
                                unset($_SESSION['error']);
                            }
                            header("location:../../../index.php?page=profile");
                            setcookie("success", "Thay đổi mật khẩu thành công !!!", time()+1,"/","",0);
                        }
                        else{
                            $_SESSION['error']=true;
                            header("location:../../../index.php?page=profile");
                            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
                        }
                    }
                }
                else{
                    $_SESSION['error']=true;
                    header("location:../../../index.php?page=profile");
                    setcookie("error", "Mật khẩu mới không khớp !!!", time()+1,"/","",0);  
                }
            }
            else{
                $_SESSION['error']=true;
                header("location:../../../index.php?page=profile");
                setcookie("error", "Mật khẩu cũ không đúng !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>