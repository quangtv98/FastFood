<?php if(in_array(1, $_SESSION['id_per']) || in_array(6, $_SESSION['id_per'])){ ?>
<div class="container mt-4">
    <div id="accordion">
        <div class="text-center">
            <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseOne"><i class="fas fa-plus"> Thêm mới</i></a>
            <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseTwo">Các chương trình</a>
            <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseThree">Phí vận chuyển</a>
        </div>

        <div id="collapseOne" class="container collapse mt-4 pb-4 shadow <?php if(isset($_GET['act'])) echo 'show' ?>" data-parent="#accordion">
            <form action="lib/admin/process/add_promotions.php" method="POST">
                <div class="d-flex row">
                    <div class="col-md-5 border p-3">
                        <div class="border rounded p-3">
                            <div class="form-group">
                                <label for="name_promo">Tên chương trình khuyến mãi :</label>
                                <input type="text" name="name_promo" id="name_promo" class="form-control" value="<?php if(isset($_SESSION['name_promo'])) echo $_SESSION['name_promo'] ?>" required>
                            </div>
                            <p class="text-uppercase text-center">Thời gian áp dụng</p>
                            <div class="d-inline-flex">
                                <div class="form-group mr-5">
                                    <label for="datepicker_1">Ngày bắt đầu :</label>
                                    <input type="text" id="datepicker_1" name="date_start" class="form-control" value="<?php if(isset($_SESSION['date_start'])) echo $_SESSION['date_start'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="datepicker_2">Ngày kết thúc :</label>
                                    <input type="text" id="datepicker_2" name="date_end" class="form-control" value="<?php if(isset($_SESSION['date_end'])) echo $_SESSION['date_end'] ?>" required>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-7 border p-3 pb-n1">
                        <div class="border rounded p-3"> 
                            <p>Loại khuyến mãi :</p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="type_promo" <?php if(isset($_SESSION['type_promo']) && $_SESSION['type_promo'] == 1) echo 'checked' ?> id="radio1" value="1" class="custom-control-input">
                                <label class="custom-control-label" for="radio1">Giảm theo số tiền</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="type_promo" <?php if(isset($_SESSION['type_promo']) && $_SESSION['type_promo'] == 2) echo 'checked' ?> id="radio2" value="2" class="custom-control-input">
                                <label class="custom-control-label" for="radio2">Giảm theo phần trăm</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="type_promo" <?php if(isset($_SESSION['type_promo']) && $_SESSION['type_promo'] == 3) echo 'checked' ?> id="radio3" value="3" class="custom-control-input" <?php if(isset($_SESSION['choose_pro_in_promotion'])) echo 'checked' ?>>
                                <label class="custom-control-label" for="radio3">Giảm giá trên từng sản phẩm</label>
                            </div>
                            <div id="input-value" style="display: none">
                                <label id="show_promotions" class="pt-3 mt-1"></label>
                                <div class="form-group form-inline">
                                    <input type="number" name="value" id="value" class="form-control text-center w-input" value="<?php if(isset($_SESSION['value'])) echo $_SESSION['value'] ?>" min="0" required>
                                    <span class="ml-3" id="show_unit"></span>
                                </div>
                                <p class="text-warning" id="show_message"></p>
                            </div>
                            <div class="mt-3" id="btn-choose" <?php if(!isset($_SESSION['choose_pro_in_promotion'])) echo 'style="display: none"' ?> >
                                <a href="" onclick="clickChoose()" class="btn btn-warning btn-sm" id="button5" data-toggle="modal" data-target="#add_product" data-toggle="tooltip" title="Chọn sản phẩm"><i class="fas fa-plus">&nbsp;</i>Chọn sản phẩm</a>
                            
                                <?php if(isset($_SESSION['choose_pro_in_promotion'])){ ?>
                                <div class="border rounded overflow-auto p-3 mt-3" id="choose_pro_in_promotions" style="max-height:700px">
                                    <table class="table-hover text-center">
                                        <thead>
                                            <th>STT</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên</th>
                                            <th>Giá</th>
                                            <th>Giá sau giảm</th>
                                            <th>Xóa</th>
                                        </thead>
                                        <tbody>
                                        <tr><td colspan="5"><h6></h6></td></tr>
                                        <?php $i=0;
                                        foreach($_SESSION['choose_pro_in_promotion'] as $id_pro => $qty){
                                            $stmt=$conn->prepare('SELECT name_pro,images,price FROM product WHERE id_pro=:id_pro AND status=:status');
                                            $stmt->execute(['id_pro'=>$id_pro, 'status'=>'1']);
                                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $i++;
                                            foreach($result as $row){ ?>
                                                <tr>
                                                    <td width="40px"><?php echo $i ?></td>
                                                    <td width="100px"><img src="./images/<?php echo $row['images'] ?>" class="border rounded" id="img_promotions" alt=""></td>
                                                    <td width="100px"><?php echo $row['name_pro'] ?></td>
                                                    <td width="100px"><?php echo number_format($row['price']).' '.'<u>đ</u>' ?></td>
                                                    <td width="130px"><input type="number" class="form-control text-center" name="reduced_price[<?php echo $id_pro ?>]" value="<?php echo $_SESSION['choose_pro_in_promotion'][$id_pro]['reduced_price']?>" min="0" max="<?php echo $row['price'] ?>" required></td>
                                                    <td width="100px"><a href="lib/admin/process/del_in_choose_promotions.php?id_pro=<?php echo $id_pro ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                                </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <input type="submit" id="btn-save" onclick="checkInfo()" class="btn btn-danger btn-sm px-4" name="submit" value="Lưu">
                </div>
            </form>
        </div>

        <!-- Form quản lý các chương trình khuyến mãi -->
        <div id="collapseTwo" class="collapse text-center <?php if(isset($_GET['promotions'])) echo 'show' ?> mt-4 px-3" data-parent="#accordion">
            <?php 
                // Tính tổng số cột
                $stmt=$conn->prepare('SELECT count(id_promo) AS total_record FROM promotions');
                $stmt->execute();
                $row=$stmt->fetch();
                $total_record=$row['total_record'];
                if($total_record > 0){ ?>
                <table class="table-bordered table-hover show col-md-12 text-center">
                    <thead>
                        <th>Tên CT</th>
                        <th>Loại KM</th>
                        <th>Giá trị</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th width="50px">cập nhật</th>
                    </thead>
                    <tbody>
                    <?php
                        // Tính limit và current_page
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit=10;
                        // Tính tổng số trang
                        $total_page=ceil($total_record / $limit);
                        // Giới hạn current_page trong khoảng 1 đến total_page
                        if ($current_page > $total_page){
                            $current_page = $total_page;
                        }
                        else if ($current_page < 1){
                            $current_page = 1;
                        }
                        // Tìm Start
                        $start = ($current_page - 1) * $limit;
                        $stmt = $conn->prepare('SELECT * FROM promotions ORDER BY id_promo DESC LIMIT :start, :limit');
                        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt -> execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) { ?>
                        <tr>
                            <td height="35px"><?php echo $row['name_promo'] ?></td>
                            <td><?php echo name_type_promotions($row['type_promo']) ?></td>
                            <td><?php echo unit_promotions($row['type_promo'],$row['value']) ?></td>
                            <td><?php echo date_format(date_create($row['date_start'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                            <td><?php echo date_format(date_create($row['date_end'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                            <td><?php echo status_promotions($row['status']) ?></td>
                            <td><a href="" class="text-info <?php if($row['status']==3) echo 'isDisabled' ?>" data-toggle="modal" data-target="<?php echo '#promotions'.$row['id_promo'] ?>" 
                            data-toggle="tooltip" title="Cập nhật chương trình khuyến mãi"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php 
            if($total_record > $limit){ ?>
                <!-- Tiến hành phân trang -->
                <?php pagination($current_page, $total_page,"admin.php?action=promotions&page=") ?>
            <?php }} ?>
        </div>

        <!-- Hộp thoại chọn sản phẩm tham gia vào chương trình khuyến mãi -->
        <div class="modal" id="add_product">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-danger text-white">
                        <h6 class="modal-title">Chọn các sản phẩm tham gia chương trình khuyến mãi</h6>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="col-md-12 modal-body text-center">
                        <form action="lib/admin/process/choose_product_promotions.php" class="px-3" method="POST">
                            <table class="text-center mb-4">
                                <thead>
                                    <th>Hình ảnh</th>
                                    <th>Tên</th>
                                    <th>Giá</th>
                                    <th>Chọn</th>
                                </thead>
                                <tbody>
                                <?php
                                $stmt=$conn->prepare('SELECT id_type,name_type FROM product_type WHERE status="1"');
                                $stmt->execute();
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $row_s){ 
                                    $id_type=$row_s['id_type'];
                                    $stmt=$conn->prepare('SELECT id_pro,name_pro,images,price FROM product WHERE status=:status AND id_type=:id_type');
                                    $stmt->execute(['status'=>'1', 'id_type'=>$id_type]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                                    <tr>
                                        <td colspan="4"><h5 class="text-uppercase text-danger mt-2"><?php echo $row_s['name_type'] ?></h5></td>
                                    </tr>
                                <?php
                                    foreach($result as $row){ 
                                        if(isset($_SESSION['choose_pro_in_promotion'])){
                                            $id_pro=$row['id_pro'];
                                            $check=FALSE;
                                            foreach($_SESSION['choose_pro_in_promotion'] as $key => $value){
                                                if($key == $id_pro){
                                                    $check=TRUE;
                                                }
                                            }
                                        } ?>
                                    <tr>
                                        <td width="100px"><img src="./images/<?php echo $row['images'] ?>" class="border rounded" id="img_promotions" alt=""></td>
                                        <td width="200px"><?php echo $row['name_pro'] ?></td>
                                        <td width="100px"><?php echo number_format($row['price']).' '.'<u>đ</u>' ?></td>
                                        <td width="100px">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $row['id_pro'] ?>" name="choose['<?php echo $row['id_pro'] ?>']" value="<?php echo $row['id_pro'] ?>" <?php if(isset($_SESSION['choose_pro_in_promotion'])){ if($check==TRUE) echo 'checked';}?>>
                                                <label class="custom-control-label" for="<?php echo $row['id_pro'] ?>"></label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }} ?>
                                </tbody>
                            </table>
                            <div class="fixed-bottom" style="bottom:30px; left:330px">
                                <input type="submit" onclick="clickChoose()" name="submit" class="btn btn-danger btn-sm px-5 py-2" value="Thêm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hộp thoại dialog được gọi đến nếu ấn cập nhật chương trình khuyến mãi -->
        <?php
            $stmt=$conn->prepare('SELECT * FROM promotions');
            $stmt->execute();
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) { ?>

            <!-- form Cập nhật chương trình khuyến mãi -->
            <div class="modal" id="<?php echo 'promotions'.$row['id_promo'] ?>">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header bg-danger text-white">
                            <h6 class="modal-title">Cập nhật chương trình khuyến mãi</h6>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body text-center">
                        <form action="lib/admin/process/update_promotions.php?id_promo=<?php echo $row['id_promo'] ?>" method="POST">
                            <div class="border rounded p-3">
                                <div class="form-group">
                                    <label for="name_promo">Tên chương trình khuyến mãi :</label>
                                    <input type="text" name="name_promo" id="name_promo" class="form-control text-center" value="<?php echo $row['name_promo'] ?>" required>
                                </div>
                                <p class="text-uppercase text-center">Thời gian áp dụng</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="datepicker_1">Ngày bắt đầu :</label>
                                        <input type="date" name="date_start" class="form-control text-center" value="<?php echo $row['date_start'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="datepicker_2">Ngày kết thúc :</label>
                                        <input type="date" name="date_end" class="form-control text-center" value="<?php echo $row['date_end'] ?>" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <div class="form-inline">
                                        <label for="status" class="mr-2">Tình trạng :</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" <?php if($row['status']==1) echo 'selected'; if($row['status'] > 1) echo 'disabled' ?> >Chưa bắt đầu</option>
                                            <option value="2" <?php if($row['status']==2) echo 'selected'; if($row['status'] > 2) echo 'disabled'  ?>>Đang diễn ra</option>
                                            <option value="3" <?php if($row['status']==3) echo 'selected' ?>>Đã kết thúc</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            <div class="mt-3">
                                <input type="submit" name="submit" class="btn btn-danger px-5 py-2" value="Cập nhật">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Điều chỉnh phí ship -->
        <div class="col-md-4 m-auto">
            <div id="collapseThree" class="collapse mt-4 p-4 shadow <?php if(isset($_GET['upd_ship'])) echo 'show' ?>" data-parent="#accordion">
            <?php 
                $stmt=$conn->prepare('SELECT * FROM ship WHERE status=:status');
                $stmt->execute(['status' => '1']);
                $row=$stmt->fetch();
                $id_ship = $row['id_ship'];
                if($id_ship == null){
            ?>
                <form action="lib/admin/process/update_ship.php" method="POST">
            <?php }else{ ?>
                <form action="lib/admin/process/update_ship.php?id_ship=<?php echo $id_ship ?>" method="POST">
            <?php } ?>
            <strong>Cập nhật lại phí vận chuyển :</strong>
                <div class="border rounded p-3 mt-3">
                    <div class="form-group">
                        <label for="ship">Phí vận chuyển (VND):</label>
                        <input type="number" name="ship" id="ship" class="form-control text-center" value="<?php echo $row['ship'] ?>" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-danger btn-sm px-4" value="cập nhật">
                    </div>
                </div> 
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script src="js/select.js" type="text/javascript"></script>