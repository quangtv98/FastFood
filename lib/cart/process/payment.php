<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";
    if(isset($_POST['submit'])){

        // Lấy thông tin khách hàng
        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        $phone = addslashes($_POST['phone']);
        if(isset($_POST['address'])){
            $address = $_POST['address'];
        }
        $ship = $_SESSION['ship'];
        $totalprice = $_SESSION['totalprice'];
        $current_date = current_datetime();
        $created_at = $current_date['created_at_date'];
        $today = $current_date['created_at_datetime'];
        $time = date_format(date_create($today),"H");
        
        // Xem có sử dụng chương trình khuyến mãi nào không
        if(isset($_SESSION['id_promo'])){
            $id_promo = $_SESSION['id_promo'];
        }else{
            $id_promo = 0;
        }

        $_SESSION['username']=$username;
        $_SESSION['email']=$email;
        $_SESSION['phone']=$phone;
        
        // Kiểm tra thời gian mua hàng của khách hàng có trong giờ hoạt động
        if($time >= 9 && $time <=22){
            // Kiểm tra tổng tiền thanh toán của hóa đơn
            if($totalprice >= 100000){
                if(isset($_SESSION['id_user'])){
                    //Cập nhập lại thông tin khách hàng
                    $id_user=$_SESSION['id_user'];
                    $query="UPDATE user SET username=:username,phone=:phone,address=:address WHERE id_user=:id_user";
                    $stmt=$conn->prepare($query);
                    $data=array('username'=>$username, 'phone'=>$phone, 'address'=>$address, 'id_user'=>$id_user);
                    $stmt->execute($data);

                    // Tạo hóa đơn
                    $query="INSERT INTO bill(id_user,username,email,phone,address,id_promo,ship,totalprice,created_at) 
                    VALUES (:id_user, :username, :email, :phone, :address, :id_promo, :ship, :totalprice, :created_at)";
                    $stmt=$conn->prepare($query);
                    $data=array('id_user'=>$id_user, 'username'=>$username, 'email'=>$email, 'phone'=>$phone, 'address'=>$address, 'id_promo'=>$id_promo, 'ship'=>$ship, 'totalprice'=>$totalprice, 'created_at'=>$created_at);
                    $check=$stmt->execute($data);

                    if($check){
                        // Lấy ra hóa đơn vừa mới insert vào
                        $id_bill=$conn->lastInsertId();

                        // Lấy thông tin đơn hàng
                        if(isset($_SESSION['cart'])){
                            $query="SELECT id_pro,price FROM product WHERE id_pro IN (";
                                foreach($_SESSION['cart'] as $id_pro => $value) { 
                                    $query.=$id_pro.","; 
                                } 
                            $query=substr($query, 0, -1).")";
                            $stmt=$conn->prepare($query);
                            $stmt->execute();
                            $result_1=$stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($result_1 as $row){
                                // Lấy ra thông tin sản phẩm có trong giỏ hàng
                                $id_pro=$row['id_pro'];
                                $qty=$_SESSION['cart'][$id_pro]['qty'];
                                $price=$row['price'];

                                // Lưu chi tiết đơn hàng
                                $query_2="INSERT INTO bill_detail(id_bill,id_pro,qty,price) VALUES (:id_bill,:id_pro,:qty,:price)";
                                $stmt=$conn->prepare($query_2);
                                $data=array('id_bill'=>$id_bill, 'id_pro'=>$id_pro, 'qty'=>$qty, 'price'=>$price);
                                $check_2=$stmt->execute($data);
                            }

                            if($check_2){
                                unset($_SESSION['cart']);
                                unset($_SESSION['ship']);
                                unset($_SESSION['totalprice']);
                                unset($_SESSION['email']);
                                unset($_SESSION['phone']);
                                unset($_SESSION['address']);
                                if(isset($_SESSION['home'])){
                                    unset($_SESSION['home']);
                                }
                                if(isset($_SESSION['id_promo'])){
                                    unset($_SESSION['id_promo']);
                                }

                                // Xóa đơn hàng trong bảng tạm
                                $stmt=$conn->prepare('DELETE FROM cart WHERE id_user=:id_user');
                                $stmt->execute(['id_user' => $id_user]);
                
                                header("location:../../../index.php?page=cart");
                                setcookie("success", "Thanh toán thành công !!!", time()+1,"/","",0);
                            }
                            else{
                                header("location:../../../index.php?page=payment");
                                setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
                            }
                        }
                    }
                    else{
                        header("location:../../../index.php?page=payment");
                        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
                    }
                }
                else{
                    header("location:../../../index.php?page=signin");
                    setcookie("error", "Bạn phải đăng nhập để thanh toán !!!", time()+1,"/","",0);
                }
            }else{
                header("location:../../../index.php?page=payment");
                setcookie("error", "Hóa đơn của qúy khách phải trên 100,000 <u>đ</u>, Vui lòng mua thêm để được thanh toán !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php?page=payment");
            setcookie("error", "Đơn hàng đi giao chỉ được áp dụng từ khung giờ 9h sáng đến 21h tối !!!", time()+1,"/","",0);
        }
    }
?>