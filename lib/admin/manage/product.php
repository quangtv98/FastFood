<?php if(in_array(1, $_SESSION['id_per']) || in_array(3, $_SESSION['id_per'])){ ?>
<div class="container text-center mt-4">
    <div id="accordion">
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseOne">Thêm loại sản phẩm</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseTwo">Thêm sản phẩm</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseThree">Thêm combo</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseFour">Quản lý loại sản phẩm</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseFive">Quản lý sản phẩm</a>
        <a class="btn btn-info btn-sm" id="button2" data-toggle="collapse" href="#collapseSix">Quản lý Combo</a>
        
        <!-- form thêm loại sản phẩm -->
        <div id="collapseOne" class="collapse text-center <?php if(isset($_GET['add_type'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <div class="col-md-4 border rounded shadow p-3">
                    <form action="lib/admin/process/add_product_type.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <select name="status" id="" class="form-control">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name_type" class="form-control" value="<?php if(isset($_SESSION['name_type'])) echo $_SESSION['name_type'] ?>" placeholder="Tên loại sản phẩm" required>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="images" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Chọn hình ảnh</label>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Thêm loại sản phẩm">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- form thêm sản phẩm -->
        <div id="collapseTwo" class="collapse text-center <?php if(isset($_GET['add_pro'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <div class="col-md-4 border rounded shadow p-3">
                    <form action="lib/admin/process/add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <select name="status" id="" class="form-control">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="id_type" id="" class="form-control">
                                <!-- <option value="" selected>--Chọn loại sản phẩm--</option> -->
                            <?php
                                $stmt=$conn->prepare('SELECT * FROM product_type WHERE id_type <> "1" AND status="1"');
                                $stmt->execute();
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                            ?>
                                <option value="<?php if(isset($_SESSION['id_type'])) echo $_SESSION['id_type'];else echo $row['id_type'] ?>"><?php echo $row['name_type'] ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name_pro" class="form-control" value="<?php if(isset($_SESSION['name_pro'])) echo $_SESSION['name_pro'] ?>" placeholder="Tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="price" class="form-control" value="<?php if(isset($_SESSION['price'])) echo $_SESSION['price'] ?>" placeholder="Giá" required pattern="[0-9]">
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="images" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Chọn hình ảnh</label>
                        </div>
                        <div class="form-group">
                            <textarea name="descript" class="form-control" placeholder="Mô tả" cols="30" rows="3"><?php if(isset($_SESSION['descript'])) echo $_SESSION['descript'] ?></textarea>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Thêm sản phẩm">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- form thêm combo sản phẩm -->
        <div id="collapseThree" class="collapse text-center <?php if(isset($_GET['add_combo'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <div class="border rounded shadow p-3">
                    <form action="lib/admin/process/add_combo.php" method="POST" enctype="multipart/form-data">
                        <div class="d-flex row px-3">
                            <div class="<?php if(isset($_SESSION['choose'])) echo 'col-md-5'; ?> border rounded p-3">
                                <div class="form-group">
                                    <a href="" class="btn btn-outline-info btn-sm w-100" data-toggle="modal" data-target="#add_product" data-toggle="tooltip" title="thêm sản phẩm"><i class="fas fa-plus">&nbsp;</i>Chọn sản phẩm</a>
                                </div>
                                <div class="form-group">
                                    <select name="status" id="" class="form-control">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name_combo" class="form-control" placeholder="Tên combo" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="price" class="form-control" placeholder="Giá" required pattern="[0-9]">
                                </div>
                                <div class="custom-file mb-3">
                                    <input type="file" name="images" class="custom-file-input" id="customFile" required>
                                    <label class="custom-file-label" for="customFile">Chọn hình ảnh</label>
                                </div>
                                <div class="form-group">
                                    <textarea name="descript" class="form-control" placeholder="Mô tả" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <?php if(isset($_SESSION['choose'])){ ?>
                            <div class="col-md-7 border rounded overflow-auto p-3" style="height:400px">
                                <table class="table-hover text-center">
                                    <thead>
                                        <th>STT</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Xóa</th>
                                    </thead>
                                    <tbody>
                                    <tr><td colspan="5"><h1></h1></td></tr>
                                    <?php $i=0;
                                    foreach($_SESSION['choose'] as $id_pro => $qty){
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
                                                <td width="100px"><input type="number" class="form-control text-center" name="qty[<?php echo $id_pro ?>]" value="<?php echo $_SESSION['choose'][$id_pro]['qty']?>" min="1" max="10" required></td>
                                                <td width="100px"><a href="lib/admin/process/del_in_choose_combo.php?id_pro=<?php echo $id_pro ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                            </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-danger btn-sm px-4" name="submit" value="Thêm Combo">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quản lý loại sản phẩm -->
        <div id="collapseFour" class="collapse text-center <?php if(isset($_GET['type_pro'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">
                <table class="table-hover table-bordered col-md-9 shadow">
                    <thead>
                        <tr>
                            <td height="40px">STT</td>
                            <td>Mã loại</td>
                            <td>Tên loại</td>
                            <td>Hình ảnh</td>
                            <td width="100px">Trạng thái</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $stmt=$conn->prepare('SELECT * FROM product_type ORDER BY id_type DESC');
                            $stmt->execute();
                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $key=>$row) {
                        ?>
                        <tr>
                            <td height="40px"><?php echo $key+1 ?></td>
                            <td><?php echo $row['id_type'] ?></td>
                            <td><?php echo $row['name_type'] ?></td>
                            <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                            <td><a href="lib/admin/process/change_status_product_type.php?id_type=<?php echo $row['id_type'] ?>&status=<?php echo $row['status'] ?>" class="text-success"><?php echo status_active($row['status']) ?></a></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quản lý sản phẩm -->
        <div id="collapseFive" class="collapse text-center <?php if(isset($_GET['product'])) echo 'show' ?>" data-parent="#accordion">
        <div class="text-uppercase mt-4">
            <ul class="nav nav-pills d-flex justify-content-center">
            <?php
                $query="SELECT * FROM product_type WHERE id_type <> '1'";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    $id_type=$row['id_type'];
            ?>
                <li class="nav-items mr-1">
                    <a href="admin.php?action=product&product&id_type=<?php echo $id_type ?>" class="nav-link btn btn-outline-warning btn-sm <?php if(isset($_GET['id_type']) && $_GET['id_type']==$id_type) echo "active" ?>" id="button2"><?php echo $row['name_type'] ?></a>
                </li>
            <?php } ?>
            </ul>
        </div>
            <div class="form-group d-flex justify-content-center mt-4">
                <input class="form-control w-50" id="Input" type="text" placeholder="Nhập thông tin sản phẩm muốn tìm..">
            </div>
            <?php 
                if(isset($_GET['id_type'])){
                    $id_type=$_GET['id_type'];
                    $stmt=$conn->prepare('SELECT count(id_pro) AS total_record FROM product WHERE id_type=:id_type AND id_type <> "1"');
                    $stmt->bindValue(':id_type', $id_type, PDO::PARAM_INT);
                }
                else{
                    $stmt=$conn->prepare('SELECT count(id_pro) AS total_record FROM product WHERE id_type <> "1"');
                }
                $stmt->execute();
                $row=$stmt->fetch();
                $total_record=$row['total_record'];
                if($total_record > 0){ ?>
            <div class="d-flex justify-content-center mt-4 pb-4">
                <table class="table-hover table-bordered col-md-12 shadow">
                    <thead>
                        <tr>
                            <td>Mã SP</td>
                            <td>Tên</td>
                            <td>Hình ảnh</td>
                            <td width="100px">Giá</td>
                            <td>Số lượng</td>
                            <td>Loại SP</td>
                            <td>Mô tả</td>
                            <td width="50px">Trạng thái</td>
                            <td width="50px">Cập nhật</td>
                        </tr>
                    </thead>
                    <tbody id="Table">
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

                            if(isset($_GET['id_type'])){
                                $id_type=$_GET['id_type'];
                                $stmt=$conn->prepare('SELECT p.id_pro,p.name_pro,p.images,p.price,p.qty,p.status,p.descript,t.name_type FROM product p INNER JOIN product_type t ON (p.id_type=t.id_type) WHERE p.id_type=:id_type ORDER BY id_pro DESC LIMIT :start, :limit');
                                // $stmt=$conn->prepare('SELECT * FROM product p LEFT JOIN product_type t ON (p.id_type=t.id_type) WHERE p.id_type=:id_type ORDER BY id_pro DESC LIMIT :start, :limit');
                                $stmt->bindValue(':id_type', $id_type, PDO::PARAM_INT);
                                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                            }
                            else{
                                $stmt=$conn->prepare('SELECT p.id_pro,p.name_pro,p.images,p.price,p.qty,p.status,p.descript,t.name_type FROM product p INNER JOIN product_type t ON (p.id_type=t.id_type) WHERE p.id_type <> "1" ORDER BY id_pro DESC LIMIT :start, :limit');
                                // $stmt=$conn->prepare('SELECT * FROM product p LEFT JOIN product_type t ON (p.id_type=t.id_type) WHERE p.id_type <> "1" ORDER BY id_pro DESC LIMIT :start, :limit');
                                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                            }
                            $stmt->execute();
                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['id_pro'] ?></td>
                            <td><?php echo $row['name_pro'] ?></td>
                            <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                            <td><?php echo number_format($row['price']) ?> <u>đ</u></td>
                            <td><?php echo $row['qty'] ?></td>
                            <td><?php echo $row['name_type'] ?></td>
                            <td><?php echo $row['descript'] ?></td>
                            <td><a href="lib/admin/process/change_status_product.php?id_pro=<?php echo $row['id_pro'] ?>&status=<?php echo $row['status'] ?>&page=<?php echo $_GET['page'] ?>" class="text-success"><?php echo status_active($row['status']) ?></a></td>
                            <td><a href="" class="text-info" data-toggle="modal" data-target="<?php echo '#product'.$row['id_pro'] ?>" data-toggle="tooltip" title="Cập nhật sản phẩm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php 
            if($total_record > $limit){ ?>
                <!-- Tiến hành phân trang -->
                <?php pagination($current_page, $total_page,"admin.php?action=product&product&page=") ?>
            <?php }} ?>
        </div>

        <!-- Quản lý combo sản phẩm -->
        <div id="collapseSix" class="collapse text-center <?php if(isset($_GET['combo'])) echo 'show' ?>" data-parent="#accordion">
            <div class="form-group d-flex justify-content-center mt-4">
                <input class="form-control w-50" id="Input_s" type="text" placeholder="Nhập thông tin combo sản phẩm muốn tìm..">
            </div>
            <?php
                // Tính tổng số cột
                $stmt=$conn->prepare('SELECT count(id_pro) AS total_record FROM product WHERE id_type = "1"');
                $stmt->execute();
                $row=$stmt->fetch();
                $total_record=$row['total_record'];
                if($total_record > 0){ ?>
                    <div class="d-flex justify-content-center mt-4 pb-4">
                        <table class="table-hover table-bordered col-md-12 shadow">
                            <thead>
                                <tr>
                                    <td>Mã Combo</td>
                                    <td>Tên</td>
                                    <td>Hình ảnh</td>
                                    <td width="250px">Chi tiết</td>
                                    <td width="80px">Giá</td>
                                    <td>Số lượng</td>
                                    <td width="50px">Trạng thái</td>
                                    <td width="50px">Cập nhật</td>
                                </tr>
                            </thead>
                            <tbody id="Table_s">
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
                                    $stmt=$conn->prepare('SELECT * FROM product WHERE id_type="1" ORDER BY id_pro DESC LIMIT :start, :limit');
                                    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                                    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id_pro'] ?></td>
                                    <td><?php echo $row['name_pro'] ?></td>
                                    <td><img src="./images/<?php echo $row['images'] ?>" class="img-thumbnail" id="img" alt=""></td>
                                    <td><?php echo $row['descript'] ?></td>
                                    <td><?php echo number_format($row['price']) ?> <u>đ</u></td>
                                    <td><?php echo $row['qty'] ?></td>
                                    <td><a href="lib/admin/process/change_status_product.php?id_combo=<?php echo $row['id_pro'] ?>&status=<?php echo $row['status'] ?>&page=<?php echo $_GET['page'] ?>" class="text-success"><?php echo status_active($row['status']) ?></a></td>
                                    <td><a href="" class="text-info" data-toggle="modal" data-target="<?php echo '#combo'.$row['id_pro'] ?>" data-toggle="tooltip" title="Cập nhật Combo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php 
                if($total_record > $limit){ ?>
                    <!-- Tiến hành phân trang -->
                    <?php pagination($current_page, $total_page,"admin.php?action=product&combo&page=") ?>
                <?php }} ?>
            </div>
    </div>
</div>

<!-- Hộp thoại dialog được gọi đến nếu ấn cập nhật combo sản phẩm -->
<?php
    $stmt=$conn->prepare('SELECT * FROM product');
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $key => $row) {
        $id_pro=$row['id_pro'];
?>
    <!-- form Cập nhật combo sản phẩm -->
    <div class="modal" id="<?php echo 'combo'.$id_pro ?>">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cập nhật combo sản phẩm</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                    <form action="lib/admin/process/update_combo.php?id_pro=<?php echo $id_pro ?>" method="POST">
                        <div class="d-flex row">
                            <div class="col-md-4 border p-3">
                                <div class="form-group">
                                    <input type="text" name="name_pro" class="form-control" value="<?php echo $row['name_pro'] ?>" placeholder="Tên combo" required>
                                </div>
                                
                                <table class="table border">
                                    <tr>
                                        <td width="100px"class="font-weight-bolder">Giá :</td>
                                        <td><input type="number" name="price" id="price" class="form-control text-center" value="<?php echo $row['price'] ?>" required pattern="[0-9]"></td>
                                    </tr>
                                    <tr>
                                        <td width="100px"class="font-weight-bolder">Số lượng</td>
                                        <td><input type="number" name="quantity" id="quantity" class="form-control text-center" value="<?php echo $row['qty'] ?>" required pattern="[0-9]"></td>
                                    </tr>
                                </table>  

                               <div class="form-group mb-n1">
                                    <textarea name="descript" class="form-control" placeholder="Mô tả" cols="30" rows="2"><?php echo $row['descript'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 border p-3">
                                <table class="table-hover text-center">
                                    <thead>
                                        <th>STT</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </thead>
                                    <tbody>
                                    <tr><td colspan="5"><h1></h1></td></tr>
                                    <?php
                                    $stmt=$conn->prepare('SELECT id_pro,qty FROM combo_detail WHERE id_combo=:id_combo');
                                    $stmt->execute(['id_combo' => $id_pro]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $key => $row_s){ 
                                        $id_pro=$row_s['id_pro'];
                                        $stmt=$conn->prepare('SELECT name_pro,images,price FROM product WHERE id_pro=:id_pro');
                                        $stmt->execute(['id_pro' => $id_pro]);
                                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row){ ?>
                                        <tr>
                                            <td width="40px"><?php echo $key+1 ?></td>
                                            <td width="100px"><img src="./images/<?php echo $row['images'] ?>" class="border rounded" id="img_promotions" alt=""></td>
                                            <td width="200px"><?php echo $row['name_pro'] ?></td>
                                            <td width="100px"><?php echo number_format($row['price']).' '.'<u>đ</u>' ?></td>
                                            <td width="100px"><input type="number" class="form-control text-center" name="qty[<?php echo $id_pro ?>]" value="<?php echo $row_s['qty'] ?>" min="1" max="10" required></td>
                                        </tr>
                                    <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-danger btn-sm px-4" name="submit" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Hộp thoại dialog được gọi đến nếu ấn cập nhật sản phẩm -->
<?php
    $stmt=$conn->prepare('SELECT * FROM product');
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $key => $row) {
?>
    <!-- form Cập nhật sản phẩm -->
    <div class="modal" id="<?php echo 'product'.$row['id_pro'] ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cập nhật sản phẩm</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                    <form action="lib/admin/process/update_product.php?id_pro=<?php echo $row['id_pro'] ?><?php if(isset($_GET['page'])) echo '&page='.$_GET['page'] ?><?php if(isset($_GET['id_type'])) echo '&id_type='.$_GET['id_type'] ?>" method="POST">
                    <!-- <p>Phần ăn chính</p> -->
                    <table class="table text-center border">
                        <tr>
                            <td colspan="2">
                                <div class="form-inline">
                                    <label for="name_pro" class="font-weight-bolder">Tên sản phẩm :</label>
                                    <input type="text" name="name_pro" id="name_pro" class="form-control w-100" value="<?php echo $row['name_pro'] ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                        </tr>
                        <tr>
                            <td><input type="number" name="price" class="form-control text-center" value="<?php echo $row['price'] ?>" required pattern="[0-9]"></td>
                            <td><input type="number" name="qty" class="form-control text-center" value="<?php echo $row['qty'] ?>" required pattern="[0-9]"></td>
                        </tr>
                    </table>
                    <input type="submit" name="submit" class="btn btn-danger btn-sm px-5 py-2" value="Cập nhật">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- form chọn sản phẩm vào combo sản phẩm -->
<div class="modal" id="add_product">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white">
                <h6 class="modal-title">Lựa chọn sản phẩm thêm vào combo sản phẩm</h6>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="col-md-12 modal-body text-center">
                <form action="lib/admin/process/choose_product_combo.php" class="px-3" method="POST">
                    <table class="table-hover text-center mb-4">
                        <thead>
                            <th>Hình ảnh</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Chọn</th>
                        </thead>
                        <tbody>
                        <?php
                        $stmt=$conn->prepare('SELECT id_type,name_type FROM product_type WHERE status="1" AND id_type <> "1"');
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
                                if(isset($_SESSION['choose'])){
                                    $id_pro=$row['id_pro'];
                                    $check=FALSE;
                                    foreach($_SESSION['choose'] as $key => $value){
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
                                        <input type="checkbox" class="custom-control-input" id="<?php echo $row['id_pro'] ?>" name="choose['<?php echo $row['id_pro'] ?>']" value="<?php echo $row['id_pro'] ?>" <?php if(isset($_SESSION['choose'])){ if($check==TRUE) echo 'checked="checked"';} ?>>
                                        <label class="custom-control-label" for="<?php echo $row['id_pro'] ?>"></label>
                                    </div>
                                </td>
                            </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                    <div class="fixed-bottom" style="bottom:30px; left:330px">
                        <input type="submit" name="submit" class="btn btn-danger btn-sm px-5 py-2" value="Thêm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
// Lấy ra tên của ảnh
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>