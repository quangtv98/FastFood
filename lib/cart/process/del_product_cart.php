<?php
    session_start();
    require_once "../../function/connect.php";
    if(isset($_GET['id_pro'])){
        $id_pro=$_GET['id_pro'];
        if(count($_SESSION['cart']) > 1){
            unset($_SESSION['cart'][$id_pro]);
        }
        else{
            unset($_SESSION['cart']);
        }

        // Xóa sản phẩm ra khỏi bảng tạm nếu có đăng nhập
        if(isset($_SESSION['id_user'])){
            $id_user=$_SESSION['id_user'];
            $query="DELETE FROM cart WHERE id_user=:id_user AND id_pro=:id_pro";
            $stmt=$conn->prepare($query);
            $stmt->execute(['id_user' => $id_user, 'id_pro' => $id_pro]);
        }
        ?>
        <script>
            window.history.back();
        </script>
        <?php 
        // header("location:../../../index.php?page=cart");
        setcookie("success", "Đã xóa sản phẩm ra khỏi giỏ hàng !!!", time()+1,"/","",0);
    }else{
        header("location:../../../index.php?page=cart");
        setcookie("error", "Có lỗi xảy ra trong quá trình xử lý !!!", time()+1,"/","",0);
    }
?>