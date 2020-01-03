<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $status = addslashes($_POST['status']);
        $role = addslashes($_POST['role']);
        $name = addslashes($_POST['name']);
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $_SESSION['password'] = $password;
        $password = md5($password);
        $phone = addslashes($_POST['phone']);
        $current_datetime=current_datetime();
        $created_at=$current_datetime['created_at_date'];
        $created_at = date_format(date_create($created_at),"Y-m-d");

        $_SESSION['status']=$status;
        $_SESSION['role']=$role;
        $_SESSION['name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
        if($role=="2"){
            // $id_per = addslashes($_POST['id_per']);
            foreach($_POST['id_per'] as $id_pro){
                $arr_per[]=$id_pro;
            }
        }
        if($role == "3"){
            $stmt=$conn->prepare('SELECT email, phone FROM user WHERE email=:email OR phone=:phone');
            $stmt->execute(['email' => $email, 'phone' => $phone]);
        }else{
            $stmt=$conn->prepare('SELECT email, phone FROM staff WHERE email=:email OR phone=:phone');
            $stmt->execute(['email' => $email, 'phone'=>$phone]);
        }

        //kiểm tra email này đã tồn tại hay chưa ?
        if($stmt->rowCount() > 0){
            header("location:../../../admin.php?action=account&add");
			setcookie("error", "Email hoặc Số điện thoại này đã được đăng ký !!!", time()+1,"/","",0);
        }
        else{
            
            if($role == "3"){
                $stmt=$conn->prepare('INSERT INTO user(username,email,password,phone,status,created_at) VALUES (:username, :email, :password, :phone, :status, :created_at)');
                $data=array('username'=>$name, 'email'=>$email, 'password'=>$password, 'phone'=>$phone, 'status'=>$status, 'created_at'=>$created_at);
                $check=$stmt->execute($data);
            }else{
                $stmt=$conn->prepare('INSERT INTO staff(staffname,email,password,phone,status,created_at) VALUES (:staffname, :email, :password, :phone, :status, :created_at)');
                $data=array('staffname'=>$name, 'email'=>$email, 'password'=>$password, 'phone'=>$phone, 'status'=>$status, 'created_at'=>$created_at);
               
                $check=$stmt->execute($data);
                
                // Lấy ra ID nhan vien vừa mới insert vào
                $id_staff=$conn->lastInsertId();
                // Insert vào chức vụ của nhân viên
                if($role == "1"){
                    // Chức vụ là quản trị viên
                    $stmt=$conn->prepare('INSERT INTO staff_per (id_staff, id_per) VALUE (:id_staff, :id_per)');
                    $stmt->execute(['id_staff'=>$id_staff, 'id_per'=>'1']);
                }
                else{
                    // Chức vụ là nhân viên
                    $stmt=$conn->prepare('INSERT INTO staff_per (id_staff, id_per) VALUE (:id_staff, :id_per)');
                    $stmt->execute(['id_staff'=>$id_staff, 'id_per'=>'8']);
                }
            }

            if($check){

                unset($_SESSION['status']);
                unset($_SESSION['role']);
                unset($_SESSION['name']);
                unset($_SESSION['email']);
                unset($_SESSION['password']);
                unset($_SESSION['phone']);
                header("location:../../../admin.php?action=account&add");
                setcookie("success", "Thêm tài khoản thành công !!!", time()+1,"/","",0);
            }
            else{
                header("location:../../../admin.php?action=account&add");
                setcookie("error", "Có lỗi xảy ra trong quá trình thêm !!!", time()+1,"/","",0);
            }
        }
    }
    else{
        header("location:../../../admin.php?action=account&add");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>