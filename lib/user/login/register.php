<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        $phone = addslashes($_POST['phone']);
        $password = addslashes($_POST['password']);
        $re_password = addslashes($_POST['re_password']);
        $password_md5 = md5($password);

        $_SESSION['username']=$username;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
            
        $stmt=$conn->prepare('SELECT email FROM user WHERE email=:email AND phone=:phone');
        $stmt->execute(['email' => $email, 'phone' => $phone]);
        $num=$stmt->rowCount();

        //kiểm tra email này đã tồn tại hay chưa ?
        if($num > 0){
            header("location:../../../index.php?page=signin");
			setcookie("error", "Email hoặc số điện thoại này đã được đăng ký !!!", time()+1,"/","",0);
        }
        else{
            //kiểm tra password có khớp không ?
            if($password != $re_password){
                header("location:../../../index.php?page=signin");
                setcookie("error", "Mật khẩu không khớp !!!", time()+1,"/","",0);
            }
            else{
                $current_datetime=current_datetime();
                $created_at=$current_datetime['created_at_date'];
                $stmt=$conn->prepare('INSERT INTO user(username,email,phone,password,created_at) VALUES (:username, :email, :phone, :password_md5, :created_at)');
                $data=array('username'=>$username, 'email'=>$email, 'phone'=>$phone, 'password_md5'=>$password_md5, 'created_at' => $created_at);
                $check=$stmt->execute($data);

                if($check){
                    $id_user = $conn->lastInsertId();
                    $_SESSION['id_user'] = $id_user;
                    
                    
                    unset($_SESSION['password_md5']);
                    unset($_SESSION['email']);
                    unset($_SESSION['phone']);

                    if(isset($_SESSION['cart'])){
                        $query="SELECT id_pro,name_pro,price,images FROM product WHERE id_pro IN (";
                            foreach($_SESSION['cart'] as $id_pro => $value) { 
                                $query.=$id_pro.","; 
                            } 
                        $query=substr($query, 0, -1).")";
                        $stmt=$conn->prepare($query);
                        $stmt->execute();
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                        // insert và giỏ hàng 
                        foreach($result as $row){
                            $id_pro=$row['id_pro'];
                            $qty=$_SESSION['cart'][$id_pro]['qty'];
                            $query="INSERT INTO cart(id_user,id_pro, qty) VALUES (:id_user,:id_pro,:qty)";
                            $stmt=$conn->prepare($query);
                            $stmt->execute(['id_user' => $id_user, 'id_pro' => $id_pro, 'qty' => $qty]);
                        }
                    }
    
                    setcookie("success", "Đăng ký tài khoản thành công !!!", time()+1,"/","",0);
                    // Quay lại trang thanh toán nếu đang chọn thanh toán
                    if(isset($_GET['action']) && $_GET['action']=="delivery_address"){
                        header("location:../../../index.php?page=delivery_address");
                    }else{
                        header("location:../../../index.php");
                    }
                }
                else{
                    header("location:../../../index.php?page=signin");
                    setcookie("error", "Có lỗi xảy ra trong quá trình đăng ký !!!", time()+1,"/","",0);
                }
            }
        }
    }
?>