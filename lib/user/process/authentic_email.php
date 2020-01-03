<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    include "../../../PHPMailer-5.2/class.smtp.php";
    include "../../../PHPMailer-5.2/class.phpmailer.php"; 
    if(isset($_POST['submit'])){
        $email=addslashes(trim($_POST['authentic_email']));
        $_SESSION['authentic_email']=$email;
        $stmt=$conn->prepare('SELECT id_user, email, username FROM user WHERE email=:email');
        $stmt->execute(['email'=>$email]);
        $row=$stmt->fetch();
        $num = $stmt->rowCount();
        if($num > 0){
            unset($_SESSION['authentic_email']);
            $id_user=$row['id_user'];
            $username=$row['username'];
            setcookie("id_authentic", $id_user, time()+3600,"/","",0);
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjklmnopqrstuvwxyz';
            $token_raw = substr(str_shuffle($permitted_chars), 0, 10);
            $token=$token_raw."7nWZLcCK0vsPzIM";
            $token=md5($token);
            
            $stmt=$conn->prepare('UPDATE user SET token=:token WHERE id_user=:id_user');
            $stmt->execute(['token'=>$token, 'id_user'=>$id_user]);
            // Tiến hành gửi mail xác nhận
            $title = "Quên mật khẩu ?";
            $content = "Link xác nhận email của bạn <a href='localhost/fastfood/lib/user/process/backlink_confirm.php?token=".$token_raw."'>tại đây</a>";
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;
            $nTo = $username; //Tên người nhận
            $mTo = $email; //Email của người nhận
            $diachicc = 'xcc@gmail.com';
            $mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
            if($mail==1){
                setcookie("success", "Xác nhận thành công !!!<br />Hãy kiểm tra email của bạn !!!", time()+1,"/","",0);
            }
            else {
                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
            }
            header("location:../../../index.php?page=signin");
        }
        else{
            setcookie("error", "Email này không tồn tại !!! Hãy kiểm tra lại !!!", time()+1,"/","",0);
        }
        header("location:../../../index.php?page=signin");
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>