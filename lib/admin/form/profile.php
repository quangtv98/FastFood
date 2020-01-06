<div class="container text-center mt-5">
    <div id="font-color" class="pb-3">
        <h3 class="text-uppercase">Hồ sơ cá nhân</h3>
    </div>
    <!-- form cập nhật mật khẩu -->
    <div class="col-md-4 border rounded shadow p-3 m-auto">
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