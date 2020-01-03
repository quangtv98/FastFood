<?php if(in_array(1, $_SESSION['id_per']) || in_array(4, $_SESSION['id_per'])){ ?>
<div class="container-fuild mt-4">
    <ul class="nav nav-pills d-flex justify-content-center pl-1">
        <?php for($i=0;$i<=4;$i++){ ?>
        <li class="nav-item card-buy mr-1"><a href="admin.php?action=bill&status=<?php echo $i ?>" id="button2" class="btn btn-outline-info btn-sm <?php if(isset($_GET['status']) && $_GET['status']==$i) echo 'active' ?>"><?php echo status_bill_admin($i) ?></a></li>
        <?php } ?>
    </ul>
</div>

<div class="text-center mt-4 px-3">
    <div class="form-group d-flex justify-content-center mt-4">
        <input class="form-control w-50" id="Input" type="text" placeholder="Nhập thông tin hóa đơn muốn tìm...">
    </div>

    <!-- Quản lý đơn hàng -->
        
    <?php                            
        // Tính tổng số cột
        $stmt=$conn->prepare('SELECT count(id_bill) AS total_record FROM bill');
        $stmt->execute();
        $row=$stmt->fetch();
        $total_record=$row['total_record'];
        if($total_record >= 1){ ?>
            <div class="d-flex justify-content-center mt-4">
            <table class="table-hover table-bordered col-md-12 shadow">
                <thead>
                    <tr>
                        <td>Mã HĐ</td>
                        <td>Tên kH</td>
                        <td>SĐT</td>
                        <td width="300px">Địa chỉ</td>
                        <td>Tổng tiền</td>
                        <td>Ngày tạo</td>
                        <td>Ngày giao</td>
                        <td>Trạng thái</td>
                        <td width="50px">Cập nhật</td>
                        <td width="50px">Xóa</td>
                        <td width="50px">Xem</td>
                    </tr>
                </thead>
                <tbody id="Table">
                    <?php                      
                        // Tính limit và current_page
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = 10;
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
                        if(isset($_GET['status'])){
                            $status=$_GET['status'];
                            $stmt=$conn->prepare('SELECT * FROM bill WHERE status=:status ORDER BY id_bill DESC LIMIT :start, :limit');
                            $stmt->bindValue(':status',$status, PDO::PARAM_INT);
                            $stmt->bindValue(':start',$start, PDO::PARAM_INT);
                            $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
                        }else{
                            $stmt=$conn->prepare('SELECT * FROM bill ORDER BY id_bill DESC LIMIT :start, :limit');
                            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        }
                        $stmt->execute();
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row){
                    ?>
                    <tr>
                        <td><?php echo $row['id_bill'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['address'] ?></td>
                        <td><?php echo number_format($row['totalprice']) ?> <u>đ</u></td>
                        <td><?php echo date_format(date_create($row['created_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                        <td width="100px"><?php if($row['updated_at'] == '') echo "chưa giao"; else echo date_format(date_create($row['updated_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y \L\ú\c H:i") ?></td>
                        <td><?php echo status_bill_admin($row['status']) ?></td>
                        <td><a href="" class="text-info <?php if($row['status'] == 4 || $row['status'] == 1) echo 'isDisabled' ?>" data-toggle="modal" data-target="#<?php echo 'update'.$row['id_bill'] ?>" data-toggle="tooltip" title="Cập nhật trạng thái đơn hàng"><i class="fa fa-pencil-square-o" aria-hidden="true"> <span class="d-none d-lg-inline-block"></span></i></a></td>
                        <td><a href="lib/admin/process/del_bill.php?id_bill=<?php echo $row['id_bill'] ?>" class="text-danger" onclick="return confirmDel()"><i class="fa fa-trash-o px-1" aria-hidden="true"></i></a></td>
                        <td><a href="" class="text-success" data-toggle="modal" data-target="#<?php echo 'view'.$row['id_bill'] ?>" data-toggle="tooltip" title="Xem đơn hàng"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>
    <?php 
    if($total_record > $limit){ ?>
        <!-- Tiến hành phân trang -->
        <?php pagination($current_page, $total_page,"admin.php?action=bill&page=") ?>
    <?php }} ?>
</div>

<?php 
    // Khởi tạo tất cả các form cập nhật hóa đơn trừ những hóa đơn đã hủy và đã hoàn tất
    $query="SELECT id_bill,status FROM bill WHERE status!=1 AND status!=4";
    $stmt=$conn->prepare($query);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){ 
        $id_bill=$row['id_bill'];
        $status = $row['status']; ?>

    <!-- Cập nhật đơn hàng -->
    <div class="modal" id="<?php echo 'update'.$id_bill ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cập nhật đơn hàng</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                    <form action="lib/admin/process/update_bill.php?id_bill=<?php echo $id_bill ?>" method="POST">
                        <div class="border p-3">
                            <table class="table border">
                            <tr>
                                <th width="80px">Mã</th>
                                <th width="140px">Tên SP</th>
                                <th width="140px">Hình ảnh</th>
                                <th width="140px">Số lượng</th>
                                <th width="140px">Giá bán</th>
                            </tr>
                            <?php  
                                // Lấy ra các sản phẩm có trong hóa đơn
                                $query="SELECT id_bill,id_pro,qty,price FROM bill_detail WHERE id_bill=:id_bill";
                                $stmt=$conn->prepare($query);
                                $stmt->execute(['id_bill'=>$id_bill]);
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $key => $row){

                                // Lấy ra thông của từng sản phẩm trong hóa đơn
                                $id_pro=$row['id_pro'];
                                $query="SELECT id_pro,name_pro,images FROM product WHERE id_pro=:id_pro";
                                $stmt=$conn->prepare($query);
                                $stmt->execute(['id_pro'=>$id_pro]);
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $row_2){ ?>
                            <tr>
                                <td><?php echo $key+1 ?></td>
                                <td><?php echo $row_2['name_pro'] ?></td>
                                <td><img src="./images/<?php echo $row_2['images'] ?>" class="img-thumbnail" alt=""></td>
                                <td><?php echo $row['qty'] ?></td>
                                <td><?php echo number_format($row['price'])." " ?><u>đ</u></td>
                            </tr>
                            <?php }} ?>
                            <tr>
                                <td></td>
                                <td colspan="2">Trạng thái đơn hàng : </td>
                                <td colspan="2">
                                    <select name="status" class="form-control pl-5" id="">
                                        <option value="0" <?php if($status==0) echo 'selected'; if($row['status'] > 0) echo 'disabled'  ?>>Chưa xử lý</option>
                                        <option value="1" <?php if($status==1) echo 'selected'; if($row['status'] > 1) echo 'disabled'  ?>>Đã hủy</option>
                                        <option value="2" <?php if($status==2) echo 'selected'; if($row['status'] > 2) echo 'disabled'  ?>>Đã xác nhận</option>
                                        <option value="3" <?php if($status==3) echo 'selected'; if($row['status'] > 3) echo 'disabled'  ?>>Đang giao</option>
                                        <option value="4" <?php if($status==4) echo 'selected' ?>>Đã hoàn tất</option>
                                    </select>
                                </td>
                            </tr>
                            </table>
                        </div>
                        <div class="pt-3">
                            <input type="submit" name="submit" class="btn btn-danger btn-sm px-5 py-2" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php 
    // Khởi tạo tất cả các form xem hóa đơn
    $query="SELECT id_bill,status FROM bill";
    $stmt=$conn->prepare($query);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){ 
        $id_bill=$row['id_bill'];
        $status = $row['status'] ?>
    <!-- Xem chi tiết đơn hàng -->
    <div class="modal" id="<?php echo 'view'.$id_bill ?>">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Chi tiết đơn hàng</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                    <div class="d-flex row">
                        <div class="col-md-4 border p-3">
                            <?php $stmt = $conn->prepare('SELECT * FROM bill WHERE id_bill=:id_bill');
                                $stmt->execute(['id_bill' => $id_bill]);
                                $row=$stmt->fetch(); ?>
                            <div class="text-left">
                                <label for="username">Họ và tên : </label>
                                <input type="text" id="username" disabled class="form-control text-center" value="<?php echo $row['username'] ?>" required="required">
                            </div>
                            <div class="text-left" >
                                <label for="phone">Số điện thoại : </label>
                                <input type="text" id="phone"disabled class="form-control text-center" value="<?php echo $row['phone'] ?>" required="required">
                            </div>
                            <div class="text-left" >
                                <label for="address">Địa chỉ : </label>
                                <textarea id="address"disabled class="form-control text-center" id="" cols="30" rows="3" required="required"><?php echo $row['address'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-8 border p-3">
                        <!-- <p>Phần ăn chính</p> -->
                            <table class="table table-hover text-center border">
                                <tr>
                                    <th>Mã</th>
                                    <th width="140px">Tên SP</th>
                                    <th width="140px">Hình ảnh</th>
                                    <th width="140px">Số lượng</th>
                                    <th width="140px">Giá bán</th>
                                </tr> 
                                <?php  
                                    // Lấy ra các sản phẩm có trong hóa đơn
                                    $query="SELECT id_bill,id_pro,qty,price FROM bill_detail WHERE id_bill=:id_bill";
                                    $stmt=$conn->prepare($query);
                                    $stmt->execute(['id_bill'=>$id_bill]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $totalprice=0;
                                    foreach($result as $key => $row){

                                    // Lấy ra thông của từng sản phẩm trong hóa đơn
                                    $id_pro=$row['id_pro'];
                                    $query="SELECT id_pro,name_pro,images FROM product WHERE id_pro=:id_pro";
                                    $stmt=$conn->prepare($query);
                                    $stmt->execute(['id_pro'=>$id_pro]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $row_2){  
                                        $totalprice+=$row['qty' ] * $row['price'] ?>
                                <tr>
                                    <td><?php echo $key+1 ?></td>
                                    <td><?php echo $row_2['name_pro'] ?></td>
                                    <td><img src="./images/<?php echo $row_2['images'] ?>" class="img-thumbnail" alt=""></td>
                                    <td><?php echo $row['qty'] ?></td>
                                    <td><?php echo number_format($row['price']) ?></td>
                                </tr>
                                <?php }} ?>
                                <?php $stmt = $conn->prepare('SELECT ship,totalprice FROM bill WHERE id_bill=:id_bill');
                                    $stmt->execute(['id_bill' => $id_bill]);
                                    $row=$stmt->fetch();
                                    $ship = $row['ship'];
                                    $totalprice = $row['totalprice']; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" class="text-right">Phí vận chuyển : </td>
                                    <td><?php echo number_format($ship) ?> <u>đ</u></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right">Tổng tiền : </td>
                                    <td><?php echo number_format($totalprice) ?> <u>đ</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" class="text-right">Trạng thái đơn hàng : </td>
                                    <td><?php echo status_bill_admin($status) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }} ?>