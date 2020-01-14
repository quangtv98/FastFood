<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    include "../../../PHPMailer-5.2/class.smtp.php";
    include "../../../PHPMailer-5.2/class.phpmailer.php"; 
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        if(isset($_POST['submit_user']) || isset($_POST['submit_staff']) || isset($_POST['submit_all'])){
            $title = addslashes($_POST['title_e']);
            $content = addslashes($_POST['content']);
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;
            $nTo = 'Quang Receiver'; //Tên người nhân
            $mTo = 'quangtv.9819@gmail.com'; //Email của người nhận
            $diachicc = 'xcc@gmail.com';

            if(isset($_POST['submit_user'])){ 
                $mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
                // $stmt=$conn->prepare('SELECT email FROM user WHERE status="1"');  
                // $stmt->execute();
                // $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                // foreach($result as $row){
                //     $email = $row['email'];
                //     send($email,$title, $message);
                // }
            }
            else if(isset($_POST['submit_staff'])){
                $mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
            }
            else{
                $mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
            }
            if($mail==1){
                unset($_SESSION['title']);
                unset($_SESSION['content']);
                setcookie("success", "Gửi email thành công !!!", time()+1,"/","",0);
            }
            else {
                setcookie("error", "Gửi email thất bại !!!", time()+1,"/","",0);
            }
            header("location:../../../admin.php?action=news&email");
        }
    }
    else{
        header("location:../../../login.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>