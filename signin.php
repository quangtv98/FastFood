<div class="container text-center" id="top">
    <div id="font-color">
        <h3 class="text-uppercase">Đăng nhập hệ thống</h3>
    </div>
    <div class="row d-flex justify-content-center mt-4">

        <!-- form đăng nhập -->
        <div class="col-md-4 border rounded shadow p-3 mr-4" <?php if(isset($_GET['id_authentic'])) echo 'hidden' ?>>
            <p class="lead">Bạn đã có tài khoản ?</p>
            <p id="font-color">Đăng nhập</p>
            <form action="lib/user/login/login.php<?php if(isset($_GET['action'])) echo '?action='.$_GET['action'] ?>" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email_u'])) echo $_SESSION['email_u'] ?>" placeholder="Nhập email" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" value="<?php if(isset($_SESSION['password_u'])) echo $_SESSION['password_u'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu" required="required">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck" name="rem">
                    <label class="custom-control-label" for="customCheck">Nhớ tài khoản</label>
                </div>
                <div>
                    <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Đăng nhập">
                </div>
                <div class="form-group pt-3" id="accordion">
                    <a href="" class="card-link" data-toggle="modal" data-target="#forgot">Quên mật khẩu ?</a>
                </div>
            </form>
        </div>
        <!-- form điền email xác nhận quên mật khẩu -->
        <div class="modal" id="forgot">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-danger text-white">
                        <h6 class="modal-title">Quên mật khẩu ?</h6>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="col-md-12 modal-body text-center">
                        <form action="lib/user/process/authentic_email.php" class="form-inline" method="POST">
                            <input type="email" class="form-control w-75" name="authentic_email" value="<?php if(isset($_SESSION['authentic_email'])) echo $_SESSION['authentic_email'] ?>" placeholder="Nhập vào email của bạn" required="required">
                            <input type="submit" name="submit" class="btn btn-danger ml-auto" value="Gửi">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- form đăng ký -->
        <div class="col-md-4 border rounded shadow p-3" <?php if(isset($_GET['id_authentic'])) echo 'hidden' ?>>
            <p class="lead">Bạn chưa có tài khoản ?</p>
            <p id="font-color">Đăng ký</p>
            <form action="lib/user/login/register.php<?php if(isset($_GET['action'])) echo '?action='.$_GET['action'] ?>" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ?>" pattern=".{6,20}" placeholder="Họ và Tên" required="required">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'] ?>" placeholder="Nhập email" required="required">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ?>" placeholder="Số điện thoại" required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="re_password" class="form-control" pattern="[a-z0-9]{6,20}" placeholder="Nhập lại mật khẩu" required="required">
                </div>
                <div>
                    <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Đăng ký">
                </div>
            </form>
        </div>
        
        <!-- form reset password -->
        <?php if(isset($_GET['id_authentic']) && isset($_COOKIE['id_authentic'])) { 
            $id_user=$_COOKIE['id_authentic'];
            $stmt=$conn->prepare('SELECT email FROM user WHERE id_user=:id_user');
            $check=$stmt->execute(['id_user'=>$id_user]);
            $row=$stmt->fetch();
            $email = $row['email']; ?>
        <div class="col-md-4 border rounded shadow p-3">
            <p class="lead">Xác nhận mật khẩu mới</p>
            <form action="lib/user/process/reset_password.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" disabled value="<?php echo $email ?>" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="new_pass" class="form-control" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu mới" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="re_new_pass" class="form-control" pattern="[a-z0-9]{6,20}" placeholder="Nhập lại mật khẩu mới" required="required">
                </div>
                <div>
                    <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Xác nhận">
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</div>