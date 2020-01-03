<div class="container text-center" id="top">
    <div id="font-color" class="pb-3">
        <h3 class="text-uppercase">Hồ sơ cá nhân</h3>
    </div>
    <div class="col-md-12 border rounded shadow">
        <?php 
            if(isset($_SESSION['id_user'])){
                $id_user=$_SESSION['id_user'];
                $query="SELECT phone, email FROM user WHERE id_user='$id_user'";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $row=$stmt->fetch();
        ?>
        <!-- form cập nhật thông tin cá nhân -->
        <div class="col-md-8 m-auto p-3">
            <strong>Thông tin liên hệ</strong>
            <form action="lib/user/process/update_profile.php" class="mt-3" method="POST">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group form-inline">
                            <label for="username">Họ Tên :</label>
                            <input type="text" name="username" id="username" class="form-control ml-auto w-75" value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ?>" pattern=".{6,20}" placeholder="Họ và Tên" required>
                        </div>
                        <div class="form-group form-inline">
                            <label for="phone">Số điện thoại :</label>
                            <input type="text" name="phone" id="phone" class="form-control ml-auto w-75" disabled value="<?php echo $row['phone'] ?>" placeholder="Số điện thoại" pattern="[0-9]{10,11}" required>
                        </div>
                        <div class="form-group form-inline">
                            <label for="email">Email :</label>
                            <input type="email" name="email" id="email" class="form-control ml-auto w-75" disabled value="<?php echo $row['email'] ?>" placeholder="Nhập email" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger btn-sm form-control w-75" name="submit" value="Cập nhật">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
        
    <div class="col-md-12 border rounded shadow mt-4">
        <!-- form cập nhật mật khẩu -->
        <div class="col-md-8 m-auto">
            <div class="row p-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="change-password">
                    <label class="custom-control-label" for="change-password"><strong>Đổi mật khẩu</strong></label>
                </div>
            </div>
        </div>
        <div class="col-md-8 m-auto p-3" id="update-password" style="display: none">
            <form action="lib/user/process/change_pass.php" method="POST">
                <div class="row mt-n3">
                    <div class="col-md-9">
                        <div class="form-group form-inline">
                            <label for="password_old">Mật khẩu cũ :</label>
                            <input type="password" name="password_old" id="password_old" class="form-control ml-auto w-75" value="<?php if(isset($_SESSION['password_old'])) echo $_SESSION['password_old'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu cũ" required>
                        </div>
                        <div class="form-group form-inline">
                            <label for="password_new">Mật khẩu mới :</label>
                            <input type="password" name="password_new" id="password_new" class="form-control ml-auto w-75" value="<?php if(isset($_SESSION['password_new'])) echo $_SESSION['password_new'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Mật khẩu mới" required>
                        </div>
                        <div class="form-group form-inline">
                            <label for="re_password_new">Nhập lại :</label>
                            <input type="password" name="re_password_new" id="re_password_new" class="form-control ml-auto w-75" value="<?php if(isset($_SESSION['re_password_new'])) echo $_SESSION['re_password_new'] ?>" pattern="[a-z0-9]{6,20}" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="submit" class="btn btn-danger btn-sm form-control w-75" name="submit" value="Cập nhật">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<script> 
    $(document).ready(function(){
        $("#change-password").click(function(){
            if(this.checked){
                $("#update-password").slideDown("slow");
            }else{
                $("#update-password").slideUp("slow");
            }
        });
    });
</script>