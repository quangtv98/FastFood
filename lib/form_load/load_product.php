<?php 
    session_start();
    require_once "../function/connect.php";
    $productNewCount = $_POST['productNewCount'];
    $id_type=$_GET['id_type'];
    $stmt=$conn->prepare('SELECT * FROM product WHERE id_type=:id_type AND status="1" LIMIT :limit');
    $stmt->bindValue(':limit', (int)$productNewCount, PDO::PARAM_INT);
    $stmt->bindValue(':id_type', (int)$id_type, PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $id_pro=$row['id_pro']; 
    ?>
    <div class="col-md-4 p-3" id="product">
        <div class="card shadow">
            <div class="image-container">
                <img class="card-img-top image-hover" src="./images/<?php echo $row['images'] ?>" alt="Card image">
                <div class="overlay">
                    <div class="text"><?php echo $row['descript'] ?></div>
                </div>
            </div>
            <div class="card-body rounded-bottom bg-white">
                <div class="card-buy">
                    <p class="text-uppercase"><?php echo $row['name_pro'] ?></p>
                    <p class="text-success"><?php echo number_format($row['price']) ?> <u>đ</u></p>
                    <p>
                        <a class="btn btn-danger btn-sm px-3" href="" data-toggle="modal" data-target="<?php echo '#product'.$id_pro ?>" data-toggle="tooltip" title="Mua và thanh toán">Đặt mua</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>