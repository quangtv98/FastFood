<?php
    session_start();
    require_once "../../function/connect.php";
    require_once "../../function/function.php";    
    if(isset($_SESSION['id_user'])){
        if(isset($_POST['submit'])){

            $id_user = $_SESSION['id_user'];
            $username = $_SESSION['username'];
            $id_address = $_SESSION['id_address'];
            $totalprice = $_SESSION['totalprice'];            
            
            // Lấy ra số điện thoại của khách hàng
            $stmt = $conn->prepare('SELECT phone FROM user WHERE id_user=:id_user');
            $stmt->execute(['id_user' => $id_user]);
            $row = $stmt->fetch();
            $phone = $row['phone']; 

            // Lấy ra phí ship đang áp dụng ở thời điểm hiện tại
            $stmt = $conn->prepare('SELECT * FROM ship WHERE status=:status');
            $stmt->execute(['status' => 1]);
            $row = $stmt->fetch();
            $ship = $row['ship'];       
            
            // Lấy ra địa chỉ giao hàng của khách hàng
            $stmt = $conn->prepare('SELECT * FROM address WHERE id_address=:id_address');
            $stmt->execute(['id_address' => $id_address]);
            $row = $stmt->fetch();
            $address = $row['name_address'];

            // Lấy ra mốc thời gian hiện tại . Ngày và giờ
            $current_date = current_datetime();
            $created_at = $current_date['created_at_date'];
            $today = $current_date['created_at_datetime'];
            $time = date_format(date_create($today),"H");
            // Kiểm tra thời gian mua hàng của khách hàng có trong giờ hoạt động
            if($time >= 9 && $time <=21){
                // Kiểm tra tổng tiền thanh toán của hóa đơn
                if($totalprice >= 100000){
                    // Tạo hóa đơn
                    $query="INSERT INTO bill(id_user,username,phone,address,ship,totalprice,created_at) 
                    VALUES (:id_user, :username, :phone, :address, :ship, :totalprice, :created_at)";
                    $stmt=$conn->prepare($query);
                    $data=array('id_user'=>$id_user, 'username'=>$username, 'phone'=>$phone, 'address'=>$address, 'ship'=>$ship, 'totalprice'=>$totalprice, 'created_at'=>$created_at);
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
                                unset($_SESSION['id_address']);
                                unset($_SESSION['totalprice']);

                                // Xóa đơn hàng trong bảng tạm
                                $stmt=$conn->prepare('DELETE FROM cart WHERE id_user=:id_user');
                                $stmt->execute(['id_user' => $id_user]);
                
                                header("location:../../../index.php?page=cart");
                                setcookie("success", "Đặt hàng thành công.<br /> Cảm ơn quý khách đã mua hàng tại cửa hàng !!!", time()+1,"/","",0);
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
                    header("location:../../../index.php?page=payment");
                    setcookie("error", "Hóa đơn của qúy khách phải trên 100,000 <u>đ</u>,<br /> Vui lòng mua thêm để được thanh toán !!!", time()+1,"/","",0);
                }
            }else{
                header("location:../../../index.php?page=payment");
                setcookie("error", "Thời gian giao hàng chỉ được áp dụng từ 9h sáng đến 21h tối !!!", time()+1,"/","",0);
            }
        }
        else{
            header("location:../../../index.php?page=payment");
            setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
        }
    }
    else{
        header("location:../../../index.php");
        setcookie("error", "Trang bạn yêu cầu không hợp lệ !!!", time()+1,"/","",0);
    }
?>