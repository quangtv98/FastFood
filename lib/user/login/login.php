<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        
        $_SESSION['email_u']=$email;
        $_SESSION['password_u']=$password;
        $password = md5($password);

        // Kiểm tra đăng nhập sai trên 3 lần chưa
        $stmt=$conn->prepare('SELECT updated_at FROM user WHERE email=:email');
        $stmt->execute(['email'=>$email]);
        $row=$stmt->fetch();
        $updated_at=$row['updated_at'];
        
        $current_datetime=current_datetime(); // function lấy thời gian
        $time=$current_datetime['created_at_datetime'];
        $sub=(strtotime($time) - strtotime($updated_at))/60;
        if($sub >= 30){
            $stmt=$conn->prepare('SELECT id_user,username,email,password,status FROM user WHERE email=:email AND password=:password');
            $stmt->execute(array('email'=>$email, 'password'=>$password));
            $num=$stmt->rowCount();

            // kiểm tra email và password này đúng không ?
            if($num > 0){
                $row=$stmt->fetch();
                $id_user = $row['id_user'];
                $status = $row['status'];
                if($status == 0){
                    setcookie("error", "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với quản trị viên để kích hoạt lại tài khoản !!!", time()+1,"/","",0);
                    header("location:../../../index.php?page=signin");
                }
                else{
                    $_SESSION['id_user'] = $row['id_user'];
                    $_SESSION['username'] = $row['username'];
                    $username = $row['username'];
                    
                    // Xóa nếu tồn tại sau khi đăng nhập đúng
                    if(isset($_SESSION['login_error'][$email])){
                        unset($_SESSION['login_error'][$email]);
                    }

                    // Lưu tài khoản trong 7 ngày nếu yêu cầu nhớ tài khoản
                    if(isset($_POST['rem'])){
                        setcookie("id_user",$_SESSION['id_user'], time()+7*24*3600,"/","",0);
                        setcookie("username",$_SESSION['username'], time()+7*24*3600,"/","",0);
                    }

                    // Lưu sản phẩm vào bảng tạm nếu có
                    if(isset($_SESSION['cart'])){
                        $query="SELECT id_pro,name_pro,price,images FROM product WHERE id_pro IN (";
                            foreach($_SESSION['cart'] as $id_pro => $value) { 
                                $query.=$id_pro.","; 
                            } 
                        $query=substr($query, 0, -1).")";
                        $stmt=$conn->prepare($query);
                        $stmt->execute();
                        $result_s=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                        // Kiểm tra xem có món hàng nào đã có trong bảng tạm
                        // Nếu có thì bỏ qua nếu chưa có thì insert vào
                        $query="SELECT id_pro FROM cart WHERE id_user=:id_user";
                        $stmt=$conn->prepare($query);
                        $stmt->execute(['id_user' => $id_user]);
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row){
                            $arr_id[]=$row['id_pro'];
                        }

                        if(count($arr_id) > 0){
                            // Lấy ra id_pro để kiểm tra tồn tại hay chưa, cái nào chưa thì insert vào
                            foreach($result_s as $row){
                                $id_pro=$row['id_pro'];
                                if((in_array($id_pro, $arr_id, FALSE))==false){
                                    $qty=$_SESSION['cart'][$id_pro]['qty'];
                                    $query="INSERT INTO cart(id_user,id_pro, qty) VALUES (:id_user,:id_pro,:qty)";
                                    $stmt=$conn->prepare($query);
                                    $stmt->execute(['id_user' => $id_user, 'id_pro' => $id_pro, 'qty' => $qty]);
                                }
                            }
                        }
                        else{
                            // tiến hành insert bình thường
                            foreach($result_s as $row){
                                $id_pro=$row['id_pro'];
                                $qty=$_SESSION['cart'][$id_pro]['qty'];
                                $query="INSERT INTO cart(id_user,id_pro, qty) VALUES (:id_user,:id_pro,:qty)";
                                $stmt=$conn->prepare($query);
                                $stmt->execute(['id_user' => $id_user, 'id_pro' => $id_pro, 'qty' => $qty]);
                            }
                        }
                    }

                    // Lấy ra giỏ hàng đã lưu trong bảng tạm
                    $query="SELECT * FROM cart WHERE id_user=:id_user";
                    $stmt=$conn->prepare($query);
                    $stmt->execute(['id_user' => $id_user]);
                    $num=$stmt->rowCount();
                    if($num > 0){
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row){
                            $id_pro=$row['id_pro'];
                            $query="SELECT name_pro,price,images FROM product WHERE id_pro=:id_pro";
                            $stmt=$conn->prepare($query);
                            $stmt->execute(['id_pro' => $id_pro]);
                            $row_s=$stmt->fetch();

                            // Tạo lại session cart
                            $_SESSION['cart'][$row['id_pro']]=array(
                                "name" => $row_s['name_pro'],
                                "price" => $row_s['price'],
                                "qty" => $row['qty']
                            );
                        }
                    }

                    setcookie("success", "Xin chào - $username !!!", time()+1,"/","",0);
                    // Quay lại trang thanh toán nếu đang chọn thanh toán
                    if(isset($_GET['action']) && $_GET['action']=="delivery_address"){
                        header("location:../../../index.php?page=delivery_address");
                    }else{
                        header("location:../../../index.php");
                    }
                }
            }else{
                // Kiểm tra đăng nhập lỗi Nếu trên 3 lần thì phải chờ 5 phút
                if(isset($_SESSION['login_error'][$email])){
                    $_SESSION['login_error'][$email]++;
                    if($_SESSION['login_error'][$email] > 3){
                        $updated_at=$current_datetime['created_at_datetime'];
                        $stmt=$conn->prepare('UPDATE user SET updated_at=:updated_at WHERE email=:email');
                        $stmt->execute(['updated_at' => $updated_at, 'email' => $email]);
                        header("location:../../../index.php?page=signin");
                        setcookie("error", "Đăng nhập sai quá 3 lần !!! Xin chờ thêm 5 phút", time()+1,"/","",0);
                    }
                    else{
                        header("location:../../../index.php?page=signin");
                        setcookie("error", "Email hoặc mật khẩu không đúng !!!", time()+1,"/","",0);
                    }
                }
                else{
                    $_SESSION['login_error'][$email] = 1;
                    header("location:../../../index.php?page=signin");
                    setcookie("error", "Email hoặc mật khẩu không đúng !!!", time()+1,"/","",0);
                }
            }
        }else{
            $term = 5 - floor($sub);
            header("location:../../../index.php?page=signin");
			setcookie("error", "Vui lòng chờ thêm $term phút nữa để đăng nhập lại !!!", time()+1,"/","",0);
        }
    }
?>