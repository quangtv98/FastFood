<?php
    session_start(); ob_start();
    require_once "lib/function/connect.php";
    if(isset($_COOKIE['id_user'])){

        $_SESSION['id_user']=$_COOKIE['id_user'];
        $_SESSION['username']=$_COOKIE['username'];
        setcookie("id_user",$_SESSION['id_user'], time()+7*24*3600,"/","",0);
        setcookie("username",$_SESSION['username'], time()+7*24*3600,"/","",0);            
        
        // Lấy ra giỏ hàng đã lưu trong bảng tạm 
        // Chỉ thực hiện lấy ra giỏ hàng này khi có lưu tùy chọn nhớ tài khoản trước đó
        $id_user=$_SESSION['id_user'];
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
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>z
<body>
    <nav class="navbar navbar-expand-sm navbar-light fixed-top bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="./images/logo.jpg" width="50px" height="50px" alt="chania"></a>
            <form class="form-inline my-2 my-lg-0" action="index.php?page=product" method="POST">
                <input type="text" class="form-control mr-sm-2" name="search" placeholder="Tìm kiếm" required>
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" name="submit" value="Tìm">
            </form>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if(!isset($_GET['page'])) echo 'active' ?>" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(isset($_GET['page']) && $_GET['page']=="menu") echo 'active' ?>" href="index.php?page=menu">Thực đơn</a>
                        <ul class="sub-menu">
                        <?php
                            $query="SELECT * FROM product_type WHERE status='1'";
                            $stmt=$conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){
                                $id_type=$row['id_type'];
                        ?>
                            <li class="pb-1"><a href="index.php?page=product&id_type=<?php echo $id_type ?>" id="button4" class="btn btn-warning btn-sm"><?php echo $row['name_type'] ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(isset($_GET['page']) && $_GET['page']=="contact") echo 'active' ?>" href="index.php?page=contact">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex <?php if(isset($_GET['page']) && $_GET['page']=="cart") echo 'active' ?>" href="index.php?page=cart"><i class="fab fa-opencart">&nbsp</i>Giỏ hàng
                        <span class="border rounded-circle"><?php if(isset($_SESSION['cart'])) echo count($_SESSION['cart']); else echo 0 ?></span>
                        </a>
                    </li>
                    <?php 
                    if (isset($_SESSION['id_user'])) {
                    // Kiểm tra xem có thông báo không
                    $id_user=$_SESSION['id_user'];
                    $stmt=$conn->prepare('SELECT id_notify FROM notify_user WHERE id_user=:id_user AND status="0"');
                    $stmt->execute([':id_user' => $id_user]);
                    $num = $stmt->rowCount(); ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-info btn-sm dropdown-toggle text-white active" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId" id="dropdown">
                            <a class="dropdown-item d-flex" href="index.php?page=notify"><span class="font-weight-light"> Thông báo <span class="badge badge-info"><?php if($num > 0) echo $num ?></span></span></a>
                            <a class="dropdown-item d-flex" href="index.php?page=view_bill"><span class="font-weight-light"> Đơn hàng của tôi</span></a>
                            <a class="dropdown-item d-flex" href="index.php?page=profile"><span class="font-weight-light"> Hồ sơ cá nhân</span></a>
                            <a class="dropdown-item d-flex" href="index.php?page=address"><span class="font-weight-light"> Sổ địa chỉ</span></a>
                            <a class="dropdown-item d-flex" href="lib/user/login/logout.php"><span class="font-weight-light"> Đăng xuất</span></a>
                        </div>
                    </li>
                    <?php } else {?>
                    <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET['page']) && $_GET['page']=="signin") echo 'active' ?>" href="index.php?page=signin"><i class="fas fa-sign-in-alt">&nbsp</i>Đăng nhập</a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>
    
    <?php include "lib/function/notify.php"; ?>

    <?php 
        if(isset($_GET['page'])){
            switch($_GET['page']){
                case "menu" : include "menu.php";
                    break;
                case "product" : include "product.php";
                    break;
                case "contact" : include "contact.php";
                    break;
                case "cart" : include "cart.php";
                    break;
                case "signin" : include "signin.php";
                    if(isset($_SESSION['id_user'])){
                        header("location:index.php");
                    }
                    break;
                case "promotions" : include "./lib/service/form/promotions.php";
                    break;
                case "delivery" : include "./lib/service/form/delivery.php";
                    break;
                case "book_party" : include "./lib/service/form/book_party.php";
                    break;
                case "delivery_address" : include "./lib/cart/form/delivery_address.php";
                    break;
                case "payment" : include "./lib/cart/form/payment.php";
                    break;
                case "view_bill" : include "./lib/cart/form/view_bill_history.php";
                    break;
                case "view_bill_detail" : include "./lib/cart/form/view_bill_detail.php";
                    break;
                case "profile" : include "./lib/user/form/profile.php";
                    break;
                case "address" : include "./lib/user/form/address.php";
                    break;
                case "notify" : include "./lib/user/form/notify.php";
                    break;
            }
        }else{
            include "home.php";
        }
    ?>
    <?php include "footer.php";?>
</body>
</html>