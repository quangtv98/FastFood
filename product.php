<div class="container pt-5 mt-5">
    <!-- <div class="col-md-12 p-0">
        <img src="./images/burger_home.jpg" width="100%" height="300px" alt="First slide">
    </div> -->
</div>

<div class="text-uppercase">
    <!-- Danh sách loại sản phẩm -->
    <ul class="nav nav-pills d-flex justify-content-center">
    <?php
        $query="SELECT * FROM product_type WHERE status='1'";
        $stmt=$conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $id_type=$row['id_type'];
    ?>
        <li class="nav-items mr-3">
            <a href="index.php?page=product&id_type=<?php echo $id_type ?>" class="nav-link btn btn-outline-warning btn-sm <?php if(isset($_GET['id_type']) && $_GET['id_type']==$id_type) echo "active" ?>" id="button5"><?php echo $row['name_type'] ?></a>
        </li>
    <?php } ?>
        <li class="nav-items">
            <a href="index.php?page=product&allProduct" class="nav-link btn btn-outline-warning btn-sm <?php if(isset($_GET['allProduct'])) echo "active" ?>" id="button5">Xem tất cả</a>
        </li>
    </ul>
</div>

<?php
    if(isset($_GET['id_type'])){
        $id_type=$_GET['id_type'];
        // Dùng cho sự kiện load thêm product
        $_SESSION['id_type']=$id_type;
    }
?>
<div class="container" id="view">
    <div class="card-deck row" id="product">
    
    <?php
        // Nếu có tìm thì thực hiện tìm kiếm trước
        if(isset($_POST['search'])){
            $search=trim(addslashes($_POST['search']));
            $stmt=$conn->prepare('SELECT * FROM product WHERE name_pro LIKE CONCAT("%",:search,"%") AND status="1"');
            $stmt->execute(['search' => $search]);
        }
        // Nếu chọn xem tất cả thì xổ form xem tất cả ở phần service
        else if(isset($_GET['allProduct'])){
            include_once "lib/service/form/all_product.php";
        }
        // Thực hiện bình thường theo id_type
        else{
            $stmt=$conn->prepare('SELECT * FROM product WHERE id_type=:id_type AND status="1" LIMIT 6');
            $stmt->execute(['id_type'=>$id_type]);
        }
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $id_pro = $row['id_pro'];
            $price = $row['price'];
            // Kiểm tra xem có chương trình khuyến mãi không ? Nếu có thì hiển thị giá khuyến mãi
            $stmt_1=$conn->prepare('SELECT *, count(id_promo) AS total_record FROM promotions WHERE status=:status');
            $stmt_1->execute(['status' => 2]);
            $row_1 = $stmt_1->fetch();
            $total_record = $row_1['total_record'];
            if($total_record > 0){
                $type_promo = $row_1['type_promo'];

                if($type_promo == 1){
                    // Lấy ra giá ban đầu để show ra
                    $Initial_price[$id_pro] = $row['price'];
                    // Giảm theo giá tiền
                    $price = $price - $row_1['value'];
                }
                else if($type_promo == 2){
                    // Lấy ra giá ban đầu để show ra
                    $Initial_price[$id_pro] = $row['price'];
                    // Giảm theo phần trăm
                    $price = $price - $price * $row_1['value'] / 100;
                }
                else if($type_promo == 3){
                    // Giảm theo từng sản phẩm
                    // Có sản phẩm có có sản phẩm không ? Nếu có thì lấy giá sau khi giảm 
                    $id_promo = $row_1['id_promo'];
                    $stmt_2=$conn->prepare('SELECT * FROM sale_product WHERE id_promo=:id_promo AND id_pro=:id_pro');
                    $stmt_2->execute(['id_promo' => $id_promo, 'id_pro' => $id_pro]);
                    $row_2 = $stmt_2->fetch();
                    if($id_pro = $row_2['id_pro']){
                        // Lấy ra giá ban đầu để show ra
                        $Initial_price[$id_pro] = $row['price'];
                        $price = $row_2['reduced_price'];
                    }
                }
            }
            $price = floor(number_format($price))*1000;
            // id_pro đã mất nên tạo lại. Chưa tìm ra nguyên nhân
            $id_pro = $row['id_pro'];
            ?>
        <div class="col-md-4 p-3">
            <div class="card shadow">
                <div class="image-container">
                    <?php if(isset($Initial_price[$id_pro])){ ?>
                    <span class="btn btn-danger rounded-circle position-absolute py-1 px-4" style="left:242px">sale</span>
                    <?php } ?>
                    <img class="card-img-top image-hover" src="./images/<?php echo $row['images'] ?>" alt="<?php echo $row['name_pro'] ?>">
                    <div class="overlay">
                        <div class="text"><?php echo $row['descript'] ?></div>
                    </div>
                </div>
                <div class="card-body rounded-bottom bg-white">
                    <div class="card-buy">
                        <p class="text-uppercase"><?php echo $row['name_pro'] ?></p>
                        <p><del class="text-black-50"><?php if(isset($Initial_price[$id_pro])) echo number_format($Initial_price[$id_pro]) ?></del>
                        <strong class="text-success ml-2"><?php echo number_format($price) ?><u>đ</u></strong></p>
                        <p><a class="btn btn-danger btn-sm px-3" href="" data-toggle="modal" data-target="<?php echo '#product'.$id_pro ?>" data-toggle="tooltip" title="Mua và thanh toán">Đặt mua</a></p>
                    </div>
                </div>
            </div>
        </div>

    <?php if($id_type != 1){ ?>
        <!-- Hộp thoại sẽ xuất hiện khi ấn nút đặt mua sản phẩm -->
        <div class="modal" id="<?php echo 'product'.$id_pro ?>">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-danger text-white">
                        <h6 class="modal-title">Thay đổi số lượng sản phẩm</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body text-center">
                        <form action="lib/cart/process/add_cart.php?id_pro=<?php echo $id_pro ?>" method="POST">
                            <p>Phần ăn chính</p>
                            <table class="table text-center border">
                                <tr>
                                    <th width="200px">Tên sản phẩm</th>
                                    <th width="200px">Số lượng</th>
                                    <th width="200px">Thành tiền<th>
                                </tr>
                                <tr>
                                    <td><?php echo $row['name_pro'] ?></td>
                                    <td><input type="number" name="qty" class="text-center form-control" min="1" max="100" pattern="[0-9]" value="1" required></td>
                                    <td><?php echo number_format(round($price,-3)) ?> <u>đ</u></td>
                                </tr>
                            </table>
                            <input type="submit" name="submit_payment" class="btn btn-danger btn-sm py-2" id="button2" value="Thanh toán">
                            <input type="submit" name="submit_add" class="btn btn-info btn-sm py-2" id="button2" value="Thêm vào giỏ hàng">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if($id_type == 1){ ?>   
        <!-- Sự kiện xem thêm -->
        <script>
            $(document).ready(function(){
                var productCount = 6;
                $("button").click(function(){
                        productCount+=6;
                    $("#product").load("lib/form_load/load_product.php", {
                        productNewCount: productCount
                    });
                });
            });
        </script>
    <?php }} ?>

    <?php if($id_type == 1){ ?>
        <!-- Hộp thoại sẽ xuất hiện khi ấn nút đặt combo sản phẩm -->
        <div class="modal" id="<?php echo 'product'.$id_pro ?>">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-danger text-white">
                        <h6 class="modal-title">Thay đổi số lượng sản phẩm</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body text-center">
                        <table class="table text-center border border-warning">
                            <p>Chi tiết phần ăn</p>
                            <tr class="bg-warning">
                                <th>Tên</th>
                                <th>Số lượng</th>
                            </tr>
                            <?php 
                                $query="SELECT p.name_pro,c.qty FROM combo_detail c INNER JOIN product p ON c.id_pro=p.id_pro WHERE c.id_combo=:id_pro";
                                $stmt=$conn->prepare($query);
                                $stmt->execute(['id_pro' => $id_pro]);
                                $result_s=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result_s as $row_s) {
                            ?>
                            <tr>
                                <td><?php echo $row_s['name_pro'] ?></td>
                                <td><p class="border border-warning w-25 m-auto rounded"><?php echo $row_s['qty'] ?></p></td>
                            </tr>
                            <?php } ?>
                        </table>
                        <form action="lib/cart/process/add_cart.php?id_pro=<?php echo $id_pro ?>" method="POST">
                            <table class="table text-center border border-warning">
                                <tr class="bg-warning">
                                    <th width="200px">Tên sản phẩm</th>
                                    <th width="200px">Số lượng</th>
                                    <th width="200px">Thành tiền</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row['name_pro'] ?></td>
                                    <td><input type="number" name="qty" class="text-center" min="1" max="100" pattern="[0-9]" value="1" required></td>
                                    <td><?php echo number_format(round($price,-3)) ?> <u>đ</u></td>
                                </tr>
                            </table>
                            <input type="submit" name="submit_payment" class="btn btn-danger btn-sm py-2" id="button2" value="Thanh toán">
                            <input type="submit" name="submit_add" class="btn btn-info btn-sm py-2" id="button2" value="Thêm vào giỏ hàng">
                        </form>
                    </div>
                </div>
            </div>
        </div>   

        <?php if($id_type != 1){ ?>   
        <!-- Sự kiện xem thêm -->
        <script>
            $(document).ready(function(){
                var productCount = 6;
                $("button").click(function(){
                        productCount+=6;
                    $("#product").load("lib/form_load/load_product.php", {
                        productNewCount: productCount
                    });
                });
            });
        </script>
    <?php }}} ?>
        
        <div class="col-md-12 mt-4 mb-n3">
            <?php if(isset($_GET['id_type'])){ ?>
                <div class="text-center">
                    <button class="btn btn-outline-warning btn-sm"><i class="fas fa-angle-double-down">&nbsp;Xem thêm</i></button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
