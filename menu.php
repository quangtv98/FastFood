<section class="container" id="top">
    <div class="row">
        <div class="col-md-6">
        <img src="./images/banner.jpg" alt="chania">
        <p id="size-md">Hơn 300 năm trước, 7 truyền thống ẩm thực khác biệt hoàn toàn đã cùng hội tụ và đúc kết nên một bí quyết ẩm thực đậm chất Mỹ
        mang tên Louisiana Cooking. Kế thừa di sản tinh tuý đó, chúng tôi tự hào mang đến cho người tiêu dùng những món ăn
        tuyệt vời nhất theo cách riêng của mình. Các thành phần gia vị được hoà trộn hoàn hảo với từng lớp bột phủ lên miếng gà rán được
        nhào nặn công phu bằng tay, cho ra đời những món ăn ngon miệng và đậm đà khó quên... Với tất cả mọi nỗ lực và tâm huyết này,
        chúng tôi hy vọng sẽ mang đến bạn một trải nghiệm ẩm thực thật phong phú và sự hài lòng tuyệt đối.</p>
        </div>
        <div class="col-md-6">
            <div id="carouselId" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselId" data-slide-to="1"></li>
                    <li data-target="#carouselId" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="./images/menu_1.jpg" width="100%" max-height="350px" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/menu_2.jpg" width="100%" max-height="350px" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/menu_3.jpg" width="100%" max-height="350px" alt="Third slide">
                        <!-- <div class="carousel-caption">
                        <h3>Combo 2 người ăn</h3>
                        </div> -->
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="false"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="false"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="text-center font-weight-bold mb-4">THỰC ĐƠN</div>
    <div class="card-deck">
        <?php
            $query="SELECT * FROM product_type WHERE status='1'";
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                $id_type=$row['id_type'];
        ?>
        <div class="col-md-4 p-3">
            <div class="card shadow">
                <a href="index.php?page=product&id_type=<?php echo $id_type ?>"><img class="card-img-top" src="./images/<?php echo $row['images'] ?>" alt="Card image"></a>
                <div class="card-body rounded-bottom">
                    <a class="text-uppercase" href="index.php?page=product&id_type=<?php echo $id_type ?>"><?php echo $row['name_type'] ?></a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>