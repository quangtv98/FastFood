<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_POST['submit_payment']) || isset($_POST['submit_add']) || isset($_GET['action'])){

        $id_pro=$_GET['id_pro'];
        $qty = addslashes($_POST['qty']);
        
        if(isset($_SESSION['cart'][$id_pro])){
            $_SESSION['cart'][$id_pro]['qty']+=$qty;
            
            // Cập nhật lại số lượng khi cập nhật giỏ hàng
            if(isset($_SESSION['id_user'])){
                $qty=$_SESSION['cart'][$id_pro]['qty'];
                $id_user=$_SESSION['id_user'];
                $stmt=$conn->prepare('UPDATE cart SET qty=:qty WHERE id_pro=:id_pro AND id_user=:id_user');
                $stmt->execute(['qty' => $qty, 'id_pro' => $id_pro, 'id_user' => $id_user]);
            }

            // Nếu người dùng chọn thanh toán
            if(isset($_POST['submit_payment'])){
                if(isset($_SESSION['id_user'])){
                    header("location:../../../index.php?page=delivery_address");
                }else{
                    header("location:../../../index.php?page=signin&action=delivery_address");
                    setcookie("error", "Bạn phải đăng nhập để thanh toán !!!", time()+1,"/","",0);
                }
            }
            else{
                setcookie("success", "Đã thêm sản phẩm vào giỏ hàng !!!", time()+1,"/","",0); ?>
                <script>
                        window.history.back();
                </script>
            <?php }
        }
        else{
            // Nếu chưa có sản phẩm nào trong giỏ hàng
            $query="SELECT name_pro,price,images FROM product WHERE id_pro=:id_pro";
            $stmt=$conn->prepare($query);
            $stmt->execute(['id_pro' => $id_pro]);
            $row=$stmt->fetch();
            $_SESSION['cart'][$id_pro]=array(
                "name" => $row['name_pro'],
                "price" => $row['price'],
                "qty" => $qty
            );

            // Thêm sản phẩm mới vào bảng tạm nếu đã đăng nhập
            if(isset($_SESSION['id_user']) && isset($_GET['id_pro'])){
                $id_user=$_SESSION['id_user'];
                $query="INSERT INTO cart(id_user, id_pro, qty) VALUES (:id_user, :id_pro, :qty)";
                $stmt=$conn->prepare($query);
                $stmt->execute(['id_user' => $id_user, 'id_pro' => $id_pro, 'qty' => $qty]);
            }
            
            // Nếu người dùng chọn thanh toán
            if(isset($_POST['submit_payment']) || isset($_GET['action'])){
                if(isset($_SESSION['id_user'])){
                    header("location:../../../index.php?page=delivery_address");
                }else{
                    header("location:../../../index.php?page=signin&action=delivery_address");
                    setcookie("error", "Bạn phải đăng nhập để thanh toán !!!", time()+1,"/","",0);
                }
            }
            else{
                setcookie("success", "Đã thêm sản phẩm vào giỏ hàng !!!", time()+1,"/","",0);
                // Nếu chọn thêm vào giỏ hàng
                // Nếu đang ở trang giao hàng thì quay về trang giao hàng
                // if(isset($_GET['delivery'])){ 
                //     setcookie("success", "Đã thêm sản phẩm vào giỏ hàng !!!", time()+1,"/","",0);
                //     // header("location:../../../index.php?page=delivery");
                // }else{
                //     setcookie("success", "Đã thêm sản phẩm vào giỏ hàng !!!", time()+1,"/","",0);
                //     // header("location:../../../index.php?page=product&id_type=$id_type");
                // } ?>
                <script>
                        window.history.back();
                </script>
                <?php }
        }
    }else{
        header("location:../../../index.php?page=product");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>