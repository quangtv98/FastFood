<div class="container" id="bg-cart">
    <div id="font-color">
        <h3 class="text-uppercase text-center">Sổ địa chỉ</h3>
    </div>
    <!-- Lấy thông tin cá nhân -->
    <?php
        if(isset($_SESSION['id_user'])){
            $id_user=$_SESSION['id_user'];
            $stmt=$conn->prepare('SELECT * FROM user WHERE id_user=:id_user');
            $stmt->execute(['id_user' => $id_user]);
            $row_s=$stmt->fetch();
    ?>        <!-- Địa chỉ khác -->
    <div class="col-md-12 p-3 border text-center mt-4" id="add-address" style="cursor: pointer">
        <span class="text-primary"><i class="fas fa-plus"></i> Thêm địa chỉ</span>
    </div>
    
    <div class="col-md-12 border p-3 mt-3" id="address_new" style="display: none">
        <form action="lib/user/process/add_address.php" method="POST">
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
                <div class="form-group form-inline ml-auto w-75">
                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="active">
                        <label class="custom-control-label" for="customCheck">Chọn địa chỉ này làm địa chỉ mặc định</label>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" class="btn btn-danger btn-sm px-5" value="Thêm">
                </div>
            </div>
        </form>
    </div>
    <!-- Địa chỉ hiện tại (Đã có hoặc chưa) -->
    <?php
        $stmt=$conn->prepare('SELECT * FROM address WHERE id_user=:id_user');
        $stmt->execute(['id_user' => $id_user]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){ ?>
            <!-- Lấy ra tất cả địa chỉ có -->
            <?php foreach($result as $row){
                $id_address = $row['id_address'];
                $page=$_GET['page']; ?>
                <div class="border p-3 mt-3">
                    <div class="clearfix">
                        <strong><?php echo $row_s['username'] ?></strong>
                        <?php if($row['status'] == 1){ ?>
                            <span class="text-success"><small><i class="far fa-check-circle"></i> Địa chỉ mặc định</small></span>
                        <?php } ?>
                        <a href="lib/user/process/update_address.php?id_address=<?php echo $id_address ?>&page=<?php echo $page ?>" class="float-right ml-3">Chỉnh sửa</a>
                        <?php if($row['status'] == 0){ ?>
                        <a href="lib/user/process/del_address.php?id_address=<?php echo $id_address ?>&page=<?php echo $page ?>" onclick="return confirmDel()" class="float-right text-danger">Xóa</a>
                        <?php } ?>
                    </div>
                    <div class="pt-2">
                        <span class="font-italic">Địa chỉ : </span><?php echo $row['name_address'] ?>
                        <br /> 
                        <span class="font-italic">Điện thoại : </span><?php echo $row_s['phone'] ?>
                    </div>
                </div>
        <?php }}else{ ?>
            <p class="text-center mb-n1">Sổ địa chỉ của bạn trống. Hãy thêm vào địa chỉ mới !!!</p>
    <?php }} ?>
</div>

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