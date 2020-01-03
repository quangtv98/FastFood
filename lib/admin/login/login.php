<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_POST['submit'])){
        $email = addslashes(trim($_POST['email']));
        $password = addslashes(trim($_POST['password']));
        $password_md5 = md5($password);
        
        $_SESSION['email_a']=$email;
        $_SESSION['password_a']=$password;

        $stmt=$conn->prepare('SELECT id_staff,staffname,email,password FROM staff WHERE email=:email AND password=:password_md5');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_md5', $password_md5);
        $stmt->execute();
        $row=$stmt->fetch();
        $id_staff=$row['id_staff'];

        //kiểm tra email này đã tồn tại hay chưa ?
        if($stmt->rowCount() > 0){

            $stmt_s=$conn->prepare('SELECT * FROM staff_per WHERE id_staff=:id_staff AND licensed=:licensed');
            $stmt_s->execute(array('id_staff'=>$id_staff, 'licensed'=>'1'));
            $result=$stmt_s->fetchAll(PDO::FETCH_ASSOC);

            if($stmt_s->rowCount() > 0){
                $row_s=$stmt_s->fetch();
                $_SESSION['id_staff'] = $id_staff;
                $_SESSION['staffname'] = $row['staffname'];
                $staffname = $row['staffname'];

                $num=$stmt_s->rowCount();
                // COOKIE[] không lưu mảng nên chuyển sang chuổi
                foreach($result as $row_s){
                    $_SESSION['id_per'][]=$row_s['id_per'];
                }
                setcookie("success", "Xin chào - $staffname !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../login.php");
                setcookie("error", "Xin lỗi. Bạn không phải là Quản Trị Viên !!!", time()+1,"/","",0);
            }

            // Lưu tài khoản trong 7 ngày nếu yêu cầu nhớ tài khoản
            if(isset($_POST['rem'])){
                $str_id_per=implode(',', $_SESSION['id_per']);
                setcookie("id_staff",$_SESSION['id_staff'], time()+7*24*3600,"/","",0);
                setcookie("staffname",$_SESSION['staffname'], time()+7*24*3600,"/","",0);
                setcookie("id_per", $str_id_per, time()+7*24*3600,"/","",0);
            }
            header("location:../../../admin.php");
        }else{
            header("location:../../../login.php");
			setcookie("error", "Email hoặc mật khẩu không đúng !!!", time()+1,"/","",0);
        }
    }
?>