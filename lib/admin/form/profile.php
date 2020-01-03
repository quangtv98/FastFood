<div class="container text-center mt-5">
    <div id="font-color" class="pb-3">
        <h3 class="text-uppercase">Hồ sơ cá nhân</h3>
    </div>
    <div class="row d-flex justify-content-center mt-4">
        <?php 
            if(isset($_SESSION['id_user'])){
                $id_user=$_SESSION['id_user'];
                $query="SELECT phone, email FROM user WHERE id_user='$id_user'";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $row=$stmt->fetch();
        ?>
        <!-- form cập nhật thông tin cá nhân -->
        <div class="col-md-4 border rounded shadow p-3 mr-3">
            <p class="lead">Thông tin liên hệ</p>
            <form action="lib/admin/process/update_profile.php" method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" disabled value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ?>" pattern=".{6,20}" placeholder="Họ và Tên">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" disabled value="<?php echo $row['phone'] ?>" placeholder="Số điện thoại" pattern="[0-9]{10,11}">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" disabled value="<?php echo $row['email'] ?>" placeholder="Nhập email">
                </div>
                <div hidden>
                    <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Cập nhật">
                </div>
            </form>
        </div>
        <?php } ?>
        <!-- form cập nhật mật khẩu -->
        <div class="col-md-4 border rounded shadow p-3">
            <p class="lead">Đổi mật khẩu</p>
            <form action="lib/admin/process/change_pass.php" method="POST">
                <div class="form-group">
                    <input type="password" name="password_old" class="form-control" value="<?php if(isset($_SESSION['password_old'])) echo $_SESSION['password_old'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu cũ">
                </div>
                <div class="form-group">
                    <input type="password" name="password_new" class="form-control" value="<?php if(isset($_SESSION['password_new'])) echo $_SESSION['password_new'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu mới">
                </div>
                <div class="form-group">
                    <input type="password" name="re_password_new" class="form-control" value="<?php if(isset($_SESSION['re_password_new'])) echo $_SESSION['re_password_new'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Nhập lại mật khẩu mới">
                </div>
                <div>
                    <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>