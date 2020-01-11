<?php
    session_start();
    if(isset($_SESSION['id_staff']) && isset($_SESSION['id_per'])){
        header("location:admin.php");
    }
?> 
<!DOCTYPE html>
<html lang="en">
    <?php include "header.php"; ?>
<body>

    <div class="container text-center" id="bg">
        <div id="font-color">
            <h3 class="text-uppercase">Đăng nhập - Quản trị hệ thống</h3>
        </div>
        <div class="d-flex justify-content-center mt-5">

            <!-- form đăng nhập -->
            <div class="col-md-4 border rounded shadow p-3">
                <p id="font-color">Đăng nhập</p>
                <form action="lib/admin/login/login.php" method="POST">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email_a'])) echo $_SESSION['email_a'] ?>" placeholder="Nhập email" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" value="<?php if(isset($_SESSION['password_a'])) echo $_SESSION['password_a'] ?>" placeholder="Mật khẩu" required="required">
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="rem">
                        <label class="custom-control-label" for="customCheck">Nhớ tài khoản</label>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-danger btn-sm px-3 py-1" name="submit" value="Đăng nhập">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>