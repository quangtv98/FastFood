<div class="d-flex justify-content-center" id="top">
    <img src="./images/birth_day.jpg" class="shadow w-75" height="350px" alt="First slide">
</div>

<div class="container mt-5" id="font-color">
    <h3 class="text-center text-uppercase">Điều kiện áp dụng</h3>
    <div class="d-flex row justify-content-center">
        <div class="col-md-5">
            <ul>
                <li><h5>Áp dụng tổ chức tại nhà, trường học, cửa hàng</h5></li>
                <li><h5>Áp dụng khi đặt tiệc 10 người trở lên</h5></li>
            </ul>
        </div>
        <div class="col-md-5">
            <ul>
                <li><h5>Không áp dụng chung với các khuyến mãi</h5></li>
                <li><h5>Vui lòng liên hệ nhân viên để có thêm thông tin</h5></li>
            </ul>
        </div>
    </div>
</div>
<div class="container text-center mt-4">
    <div id="accordion">
        <a class="btn btn-danger btn-sm px-3 py-2" id="button2" data-toggle="collapse" href="#collapseOne">Thực đơn</a>
        <a class="btn btn-danger btn-sm px-3 py-2" id="button2" data-toggle="collapse" href="#collapseTwo">Dịch vụ tổ chức</a>
        <a class="btn btn-danger btn-sm px-3 py-2" id="button2" data-toggle="collapse" href="#collapseThree">Đặt tiệc</a>

        <div id="collapseOne" class="collapse text-center show" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <img src="images/combo_party.jpg" class="rounded shadow w-75" alt="">
            </div>
        </div>
    
        <div id="collapseTwo" class="collapse" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <img src="images/bg_service_book_party.jpg" class="rounded shadow w-75" alt="">
            </div>
        </div>    

        <div id="collapseThree" class="collapse" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <!-- form đặt lịch tiệc sinh nhật -->
                <div class="col-md-8 border rounded shadow p-3">
                <form action="lib/service/process/book_party.php" method="POST">
                        <h4 class="text-uppercase py-3" id="font-color">Thông tin đặt tiệc</h4>
                        <div class="d-flex row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="parent_name" class="form-control" value="<?php if(isset($_SESSION['parent_name'])) echo $_SESSION['parent_name'] ?>" placeholder="Họ và tên người đặt tiệc" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'] ?>" placeholder="Email liên hệ" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ?>" placeholder="Số điện thoại" required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
                                </div>
                                <div class="form-group">
                                    <select name="type" id="type" class="form-control" onchange="localChange(this)">
                                        <option hidden>--Chọn nơi tổ chức--</option>
                                        <option value="1">Tổ chức tại cửa hàng</option>
                                        <option value="2">Tổ chức ngoài cửa hàng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="child_name" class="form-control" value="<?php if(isset($_SESSION['child_name'])) echo $_SESSION['child_name'] ?>" placeholder="Họ và tên chủ tiệc" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="datepicker_1" name="birthday" class="form-control" value="<?php if(isset($_SESSION['birthday'])) echo $_SESSION['birthday'] ?>" placeholder="Ngày sinh" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="datepicker_2" name="date_organized" class="form-control" value="<?php if(isset($_SESSION['date_organized'])) echo $_SESSION['date_organized'] ?>" placeholder="Ngày tổ chức tiệc" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="number" class="form-control" value="<?php if(isset($_SESSION['number'])) echo $_SESSION['number'] ?>" placeholder="Số lượng khách mời" required="required">
                                </div>
                            </div>
                            <div class="col-md-12" id="inside" hidden>
                                <div class="form-group">
                                <select name="address" class="form-control">
                                    <?php 
                                    $stmt=$conn->prepare('SELECT * FROM branch');
                                    $stmt->execute();
                                    $result_1=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result_1 as $row){ ?>
                                        <option  value="<?php echo $row['local'] ?>"><?php echo $row['local']."-".$row['hotline'] ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12 ml-0 row" id="outside" hidden>
                                <div class="col-md-4 pl-0 form-group">
                                    <!-- <label for="city">Thành Phố / Tỉnh :</label> -->
                                    <select name="city" id="city" class="form-control">
                                        <!-- <option value="" selected> --Thành Phố / Tỉnh--</option> -->
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
                                <div class="col-md-4 pl-0 form-group">
                                    <!-- <label for="district">Quận / Huyện :</label> -->
                                    <select name="district" id="district" class="form-control">
                                        <option value="">--Quận / Huyện--</option>
                                    </select>
                                </div>
                                <div class="col-md-4 pl-0 form-group">
                                    <!-- <label for="ward">Phường / Xã :</label> -->
                                    <select name="ward" id="ward" class="form-control">
                                        <option value="">--Phường / Xã--</option>
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <input type="text" name="home" class="form-control" value="<?php if(isset($_SESSION['home'])) echo $_SESSION['home'] ?>" placeholder="Số nhà, tên đường,..." required="required">
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="required" id="" cols="30" rows="2" class="form-control" placeholder="Yêu cầu thêm"><?php if(isset($_SESSION['required'])) echo $_SESSION['required'] ?></textarea>
                            </div>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Đặt tiệc">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
    // chức năng chọn nơi tổ chức tiệc
    function localChange(obj)
    {    

        // ẩn loại không chọn
        var value = obj.value;
        if (value === '1'){
            document.getElementById('inside').hidden = false;
            document.getElementById('outside').hidden = true;
            document.getElementById('home').disabled = true;
            document.getElementById('home').value = '';
        }
        else{
            document.getElementById('inside').hidden = true;
            document.getElementById('outside').hidden = false;
            document.getElementById('home').disabled = false;
        }
    }
</script>