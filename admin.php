<?php
    session_start(); ob_start();
    require_once("lib/function/connect.php");
    require_once("lib/function/function.php");
    if(isset($_COOKIE['id_staff']) && isset($_COOKIE['id_per'])){
        $_SESSION['id_staff']=$_COOKIE['id_staff'];
        $_SESSION['staffname']=$_COOKIE['staffname'];
        $_SESSION['id_per']=explode(',', $_COOKIE['id_per']);
        $str_id_per=implode(',',$_SESSION['id_per']);
        setcookie("id_staff",$_SESSION['id_staff'], time()+7*24*3600,"/","",0);
        setcookie("staffname",$_SESSION['staffname'], time()+7*24*3600,"/","",0);
        setcookie("id_per",$str_id_per, time()+7*24*3600,"/","",0);
    }
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
?>
<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>
<body>
    <div class="container-fluid">
        <div class="mt-2 mb-4">
            <ul class="nav nav-pills d-flex">
                <li class="nav-item mr-1">
                    <a id="button2" <?php if(!in_array(1, $_SESSION['id_per']) && !in_array(2, $_SESSION['id_per'])) echo "hidden" ?> class="nav-link btn btn-outline-danger btn-sm <?php if(isset($_GET['action']) && $_GET['action']=="account") echo 'active' ?>" href="admin.php?action=account&user">Quản lý người dùng</a>
                </li>
                <li class="nav-item mr-1">
                    <a id="button2" <?php if(!in_array(1, $_SESSION['id_per']) && !in_array(3, $_SESSION['id_per'])) echo "hidden" ?> class="nav-link btn btn-outline-danger btn-sm <?php if(isset($_GET['action']) && $_GET['action']=="product") echo 'active' ?>" href="admin.php?action=product&product&page=1">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item mr-1">
                    <a id="button2" <?php if(!in_array(1, $_SESSION['id_per']) && !in_array(4, $_SESSION['id_per'])) echo "hidden" ?> class="nav-link btn btn-outline-danger btn-sm <?php if(isset($_GET['action']) && $_GET['action']=="bill") echo 'active' ?>" href="admin.php?action=bill">Quản lý đơn hàng</a>
                </li>
                <li class="nav-item mr-1">
                    <a id="button2" <?php if(!in_array(1, $_SESSION['id_per']) && !in_array(6, $_SESSION['id_per'])) echo "hidden" ?> class="nav-link btn btn-outline-danger btn-sm <?php if(isset($_GET['action']) && $_GET['action']=="promotions") echo 'active' ?>" href="admin.php?action=promotions&promotions">Quản lý khuyến mãi</a>
                </li>
                <li class="nav-item">
                    <a id="button2" <?php if(!in_array(1, $_SESSION['id_per']) && !in_array(7, $_SESSION['id_per'])) echo "hidden" ?> class="nav-link btn btn-outline-danger btn-sm <?php if(isset($_GET['action']) && $_GET['action']=="news") echo 'active' ?>" href="admin.php?action=news&news">Quản lý thông báo</a>
                </li>
                <li class="ml-auto mr-3">
                    <div class="dropdown ml-auto" id="admin-name">
                        <a href="#" class="btn btn-info btn-sm dropdown-toggle" id="dropdown" data-toggle="dropdown"><?php echo $_SESSION['staffname']; ?></a>
                        <?php                
                            // Kiểm tra xem có thông báo không
                            $id_staff=$_SESSION['id_staff'];
                            $stmt=$conn->prepare('SELECT id_notify FROM notify_staff WHERE id_staff=:id_staff AND status="0"');
                            $stmt->execute([':id_staff' => $id_staff]);
                            $num = $stmt->rowCount();
                        ?>
                        <div class="dropdown-menu" id="dropdown">
                            <a class="dropdown-item d-flex" href="admin.php?action=notify"><i class="fas fa-bell"><span class="font-weight-light"> Thông báo <span class="badge badge-info"><?php if($num > 0) echo $num ?></span></span></i></a>
                            <a class="dropdown-item d-flex" href="admin.php?action=profile"><i class="fas fa-cog"><span class="font-weight-light"> Đổi mật khẩu</span></i></a>
                            <a class="dropdown-item d-flex" href="lib/admin/login/logout.php"><i class="fas fa-sign-out-alt"><span class="font-weight-light"> Đăng xuất</span></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?php include "lib/function/notify.php"; ?>
    
    <?php
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case "account" : include "lib/admin/manage/account.php";
                    break;
                case "product" : include "lib/admin/manage/product.php";
                    break;
                case "bill" : include "lib/admin/manage/bill.php";
                    break;
                case "promotions" : include "lib/admin/manage/promotions.php";
                    break;
                case "news" : include "lib/admin/manage/news.php";
                    break;
                case "profile" : include "lib/admin/form/profile.php";
                    break;
                case "notify" : include "lib/admin/form/notify.php";
                    break;
            }
        }
    ?>
    <div class="mt-5"></div>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- datetime picker -->
    <script>
        $('#datepicker_1').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
    <!-- datetime picker -->
    <script>
        $('#datepicker_2').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
    <!-- Tìm kiếm bằng ajax -->
    <script>
        $(document).ready(function(){
            $("#Input").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#Table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <!-- Tìm kiếm combo bằng ajax -->
    <script>
        $(document).ready(function(){
            $("#Input_s").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#Table_s tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
<?php 
    }else{
        header("location:login.php");
        setcookie("error", "Xin lỗi. Bạn không phải là Quản Trị Viên !!!", time()+1,"/","",0);
    }
?>