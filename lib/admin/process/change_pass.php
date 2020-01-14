<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit'])){
            if(isset($_SESSION['id_staff'])){
                $id_staff=$_SESSION['id_staff'];
                $password_old=addslashes($_POST['password_old']);
                $_SESSION['password_old']=$password_old;
                $password_old=md5($password_old);

                $password_new=addslashes($_POST['password_new']);
                $_SESSION['password_new']=$password_new;
                $password_new=md5($password_new);

                $re_password_new=addslashes($_POST['re_password_new']);
                $_SESSION['re_password_new']=$re_password_new;
                $re_password_new=md5($re_password_new);
                
                $query="SELECT password, updated_at FROM staff WHERE id_staff='$id_staff'";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $row=$stmt->fetch();
                $password=$row['password'];
                if($password==$password_old){
                    if($password_new==$re_password_new){
                        if($password==$password_new){
                            header("location:../../../admin.php?action=profile");
                            setcookie("error", "Mật khẩu mới trùng với mật khẩu cũ !!!", time()+1,"/","",0);
                        }
                        else{
                            $current_datetime=current_datetime();
                            $today=$current_datetime['created_at_date'];
                            $updated_at=$row['updated_at'];
                            $sub=(strtotime($today) - strtotime($updated_at))/86400;
                            // Chỉ được cập nhật ở lần tiếp theo sau 30 ngày
                            if($sub >= 30){
                                $stmt=$conn->prepare('UPDATE staff SET password=:password_new, updated_at=:updated_at WHERE id_staff=:id_staff');
                                $stmt->bindParam(':password_new',$password_new);
                                $stmt->bindParam(':id_staff',$id_staff);
                                $stmt->bindParam(':updated_at',$today);
                                $check=$stmt->execute();
                                if($check){
                                    unset($_SESSION['password_old']);
                                    unset($_SESSION['password_new']);
                                    unset($_SESSION['re_password_new']);
                                    header("location:../../../admin.php?action=profile");
                                    setcookie("success", "Thay đổi mật khẩu thành công !!! Lưu ý ! Việc thay đổi mật khẩu lần kết tiếp phải trên 30 ngày !!!", time()+1,"/","",0);
                                }
                                else{
                                    header("location:../../../admin.php?action=profile");
                                    setcookie("error", "Có lỗi xảy ra trong quá trình đăng ký !!!", time()+1,"/","",0);
                                }
                            }
                            else{
                                header("location:../../../admin.php?action=profile");
                                setcookie("error", "Lần thay đổi mật khẩu cuối cùng đến nay chưa được 30 ngày !!!", time()+1,"/","",0); 
                            }
                        }
                    }
                    else{
                        header("location:../../../admin.php?action=profile");
                        setcookie("error", "Mật khẩu mới không khớp !!!", time()+1,"/","",0);  
                    }
                }
                else{
                    header("location:../../../admin.php?action=profile");
                    setcookie("error", "Mật khẩu cũ không đúng !!!", time()+1,"/","",0);
                }
            }
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>