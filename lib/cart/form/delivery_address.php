<?php
    if(isset($_SESSION['id_user'])){
        $id_user=$_SESSION['id_user'];
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        // Lấy ra thông tin cá nhân
        $stmt=$conn->prepare('SELECT * FROM user WHERE id_user=:id_user');
        $stmt->execute(['id_user' => $id_user]);
        $user=$stmt->fetch();

        // Lấy ra danh sách các địa chỉ hiện có
        $stmt=$conn->prepare('SELECT * FROM address WHERE id_user=:id_user');
        $stmt->execute(['id_user' => $id_user]);
        $result=$stmt->fetchALL(PDO::FETCH_ASSOC); ?>

        <div class="container" id="bg-cart">
            <h5><strong>2. Địa chỉ giao hàng</strong></h5>
            <?php if(count($result) > 0){ ?>
            <h6>Chọn địa chỉ giao hàng có sẵn bên dưới :</h6>
            <?php } ?>
            <div class="d-flex row p-3">
                <?php 
                if(count($result) > 0){
                    foreach($result as $address){ 
                        $id_address = $address['id_address'];
                        $page=$_GET['page']; ?>

                        <div class="col-md-6 border p-3 mb-3 <?php if($address['status']==1) echo 'border-success' ?>">
                            <div class="clearfix">
                                    <strong><?php echo $user['username'] ?></strong>
                                    <?php if($address['status'] == 1){ ?><span class="float-right text-success"><small><i class="far fa-check-circle"></i> Địa chỉ mặc định</small></span><?php } ?>
                            </div>
                            <div class="py-2">
                                <span class="font-italic">Địa chỉ : </span><?php echo $address['name_address'] ?>
                                <br /> 
                                <span class="font-italic">Điện thoại : </span><?php echo $user['phone'] ?>
                            </div>
                            <div class="">
                                <a href="lib/cart/process/delivery_address.php?id_address=<?php echo $id_address ?>" class="btn btn-danger btn-sm px-3">Giao đến địa chỉ này</a>
                                <?php if($address['status'] == 0){ ?>
                                <a href="lib/user/process/del_address.php?id_address=<?php echo $id_address ?>&page=<?php echo $page ?>" onclick="return confirmDel()" class="btn btn-light btn-sm border px-3">Xóa</a>
                                <?php } ?>
                            </div>
                        </div>
                <?php }}else{ ?>
                    <p>Sổ địa chỉ của bạn trống. Hãy thêm vào địa chỉ mới !!!</p>
                <?php } ?>
            </div>
            <!-- Địa chỉ khác -->
            <h6>Bạn muốn giao hàng đến địa chỉ khác ? <span class="text-primary" id="add-address" style="cursor: pointer">Thêm địa chỉ giao hàng mới</span></h6>
            <div class="col-md-12 border p-3 mt-4" id="address_new" style="display: none">
                <form action="lib/user/process/add_address.php?page=<?php echo $page ?>" method="POST">
                    <div class="col-md-6 m-auto">
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
                        <div class="form-group ml-auto w-75">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="active">
                                <label class="custom-control-label" for="customCheck">Chọn địa chỉ này làm địa chỉ mặc định</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="submit" class="btn btn-danger btn-sm px-4" value="Giao đến địa chỉ này">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php 
        }else{
            header("location:./index.php?page=signin&action=payment");
            setcookie("error", "Bạn phải đăng nhập để thanh toán !!!", time()+1,"/","",0);
        }
    ?>

<script>
    $(document).ready(function(){
        $("#add-address").click(function(){
            $("#address_new").slideDown("slow");
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#city').change(function(){
        var city = $('#city option:selected').val();
        $.ajax({
                url:'lib/form_load/load_district.php',
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
                url:'lib/form_load/load_ward.php',
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