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
        <!-- Địa chỉ hiện tại (Đã có hoặc chưa) -->
        <div class="col-md-8 m-auto p-3">
            <strong>Địa chỉ mặc định</strong>
            <?php 
                $stmt=$conn->prepare('SELECT count(id_address) AS total_record FROM address WHERE id_user=:id_user');
                $stmt->execute(['id_user' => $id_user]);
                $result = $stmt->fetch();
                $total_record = $result['total_record'];
                if($total_record > 0){
                    $stmt=$conn->prepare('SELECT * FROM address WHERE id_user=:id_user');
                    $stmt->execute(['id_user' => $id_user]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                    <form action="lib/user/process/choose_address.php" class="mt-3" method="POST">
                        <div class="row">
                            <div class="col-md-9 text-left">
                            <!-- Lấy ra tất cả địa chỉ có -->
                            <?php foreach($result as $row){ ?>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="id_address" class="custom-control-input" <?php if($row['status'] == 1) echo 'checked' ?> id="<?php echo $row['id_address'] ?>" value="<?php echo $row['id_address'] ?>">
                                    <label class="custom-control-label" for="<?php echo $row['id_address'] ?>"><?php echo $row['name_address'] ?></label>
                                </div>
                            <?php } ?>
                            </div>

                            <?php if($total_record > 1){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-danger btn-sm form-control w-75" value="Chọn">
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </form>
                <?php }else{ ?>
                    <p class="text-center mb-n1">Bạn chưa có địa chỉ nào. Hãy thêm vào địa chỉ mới !!!</p>
                <?php } ?>
        </div>
        <hr class="my-0"><!-- Địa chỉ mới -->
        <div class="col-md-8 m-auto">
            <div class="row p-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="btn-add-address">
                    <label class="custom-control-label" for="btn-add-address"><strong>Thêm địa chỉ mới</strong></label>
                </div>
            </div>
        </div>
        <div class="col-md-8 m-auto p-3" id="add-address" style="display: none">
            <form action="lib/user/process/add_address.php" method="POST"><div class="row mt-n3">
                <div class="col-md-9">
                    <div class="form-group form-inline">
                        <label for="city">Thành Phố / Tỉnh :</label>
                        <select name="city" id="city" class="form-control ml-auto w-75">
                            <option value="" selected> --Thành Phố / Tỉnh--</option>
                            <?php 
                            $id_city=0;
                            $stmt=$conn->prepare('SELECT * FROM city ORDER BY id_city DESC');
                            $stmt->execute();
                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){ ?>
                                <option value="<?php echo $row['id_city'] ?>"><?php echo $row['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="district">Quận / Huyện :</label>
                        <select name="district" id="district" class="form-control ml-auto w-75">
                            <option value="">--Quận / Huyện--</option>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="ward">Phường / Xã :</label>
                        <select name="ward" id="ward" class="form-control ml-auto w-75">
                            <option value="">--Phường / Xã--</option>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="home">Địa chỉ :</label>
                        <input name="home" id="home" class="form-control ml-auto w-75" placeholder="Số nhà, tên đường, ..." required>
                    </div>
                    <div class="form-group form-inline ml-auto w-75">
                        <div class="custom-control custom-checkbox ">
                            <input type="checkbox" class="custom-control-input" id="customCheck" name="active">
                            <label class="custom-control-label" for="customCheck">Chọn địa chỉ này làm địa chỉ mặc định</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-danger btn-sm form-control w-75" value="Thêm">
                    </div>
                </div>
            </div>
            </form>
        </div>
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
        $("#btn-add-address").click(function(){
            if(this.checked){
                $("#add-address").slideDown("slow");
            }else{
                $("#add-address").slideUp("slow");
            }
        });
    });
</script>

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

<script type="text/javascript">
    $(document).ready(function(){
        $('#city').change(function(){
        var city = $('#city option:selected').val();
        $.ajax({
                url:'lib/function/ajax_district.php',
                type:'post',
                data:{
                    city:city,
                },
                async:true,
                dataType:'html',
                success:function(result){
                $('#district').html(result);
            }
        });
        return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#district').change(function(){
        var district = $('#district option:selected').val();
        $.ajax({
                url:'lib/function/ajax_ward.php',
                type:'post',
                data:{
                    district:district,
                },
                async:true,
                dataType:'html',
                success:function(result){
                $('#ward').html(result);
            }
        });
        return false;
        });
    });
</script>