<?php if(in_array(1, $_SESSION['id_per']) || in_array(2, $_SESSION['id_per'])){ ?>
<div class="container text-center mt-4">
    <div id="accordion">
        <a class="btn btn-outline-info btn-sm" id="button2" data-toggle="collapse" href="#collapseOne">Thêm tài khoản</a>
        <a class="btn btn-outline-info btn-sm" id="button2" data-toggle="collapse" href="#collapseTwo">Quản lý khách hàng</a>
        <a class="btn btn-outline-info btn-sm" id="button2" data-toggle="collapse" href="#collapseThree">Quản lý nhân viên</a>

        <!-- form thêm tài khoản -->
        <div id="collapseOne" class="collapse text-center <?php if(isset($_GET['add'])) echo 'show' ?>" data-parent="#accordion">
            <div class="d-flex justify-content-center mt-4">

                <div class="col-md-4 border rounded p-3">
                    <form action="lib/admin/process/add_user.php" method="POST">
                        <div class="form-group">
                            <select name="status" id="" class="form-control">
                                <option value="0" <?php if(isset($_SESSION['status']) && $_SESSION['status']=='0') echo 'selected="selected"' ?>>Ẩn</option>
                                <option value="1" <?php if(isset($_SESSION['status']) && $_SESSION['status']=='1') echo 'selected="selected"' ?>>Hiện</option>
                            </select>
                        </div>
                        <div class="form-group text-left">
                            <label for="role" class="pl-3">Chức vụ : </label>
                            <select name="role" id="role" class="form-control" onchange="getChange(this)">
                                <option value="1" <?php if(isset($_SESSION['checked']) && $_SESSION['checked']=='1') echo 'selected="selected"' ?>>Quản trị viên</option>
                                <option value="2" selected <?php if(isset($_SESSION['checked']) && $_SESSION['checked']=='2') echo 'selected="selected"' ?>>Nhân viên</option>
                                <option value="3" <?php if(isset($_SESSION['checked']) && $_SESSION['checked']=='3') echo 'selected="selected"' ?>>Khách hàng</option>
                            </select>
                        </div>
                        <div class="pl-4 border rounded" hidden id="permission">
                            <?php 
                            $stmt=$conn->prepare('SELECT * FROM permission WHERE id_per <> "1"');
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){ ?>
                                <div class="custom-control custom-checkbox text-left">
                                    <input type="checkbox" class="custom-control-input" id="<?php echo $row['id_per'] ?>" name="id_per['<?php echo $row['id_per'] ?>]'" value="<?php echo $row['id_per'] ?>">
                                    <label class="custom-control-label" for="<?php echo $row['id_per'] ?>"><?php echo $row['name_per'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" name="name" class="form-control" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name'] ?>" placeholder="Tên người dùng" required="required">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'] ?>" placeholder="Nhập email" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password'] ?>" placeholder="Mật khẩu" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" value="<?php if(isset($_SESSION['phone'])) echo $_SESSION['phone'] ?>" placeholder="Số điện thoại" required="required" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-danger btn-sm px-4 py-1" name="submit" value="Thêm tài khoản">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <!-- Quản lý khách hàng -->
        <div id="collapseTwo" class="collapse text-center <?php if(isset($_GET['user'])) echo 'show' ?>" data-parent="#accordion">
            <div class="form-group d-flex justify-content-center mt-4">
                <input class="form-control w-50" id="Input" type="text" placeholder="Nhập thông tin khách hàng muốn tìm..">
            </div>
            <?php
                // Tính tổng số cột
                $stmt=$conn->prepare('SELECT count(id_user) AS total_record FROM user');
                $stmt->execute();
                $row=$stmt->fetch();
                $total_record=$row['total_record'];
                if($total_record >= 1){ ?>
                <div class="d-flex justify-content-center my-4">
                    <table class="col-md-12 table-hover table-bordered">
                        <thead>
                            <tr>
                                <td>Mã KH</td>
                                <td>Tên</td>
                                <td>Email</td>
                                <td>SĐT</td>
                                <td>Địa chỉ</td>
                                <td width="50px">Trạng thái</td>
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

                                $stmt=$conn->prepare('SELECT * FROM user LIMIT :start, :limit');
                                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                                $stmt->execute();
                                $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result as $row){
                                    $id_user = $row['id_user'];
                                    $stmt_s = $conn->prepare('SELECT name_address FROM address WHERE id_user=:id_user AND status=:status');
                                    $stmt_s->execute(['id_user' => $id_user, 'status' => 1]);
                                    $row_s = $stmt_s->fetch();
                            ?>
                            <tr>
                                <td height="35px"><?php echo $row['id_user'] ?></td>
                                <td class="text-left"><span class="ml-2"><?php echo $row['username'] ?></span></td>
                                <td class="text-left"><span class="ml-2"><?php echo $row['email'] ?></span></td>
                                <td><?php echo $row['phone'] ?></td>
                                <td class="text-left"><span class="ml-2"><?php echo $row_s['name_address'] ?></span></td>
                                <td><a href="lib/admin/process/change_status_user.php?id_user=<?php echo $row['id_user'] ?>&status=<?php echo $row['status'] ?><?php if(isset($_GET['page'])){ echo '&page='.$page;} ?>" class="text-success"><?php echo status_active($row['status']) ?></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php 
            if($total_record > $limit){ ?>
                <!-- Tiến hành phân trang -->
                <?php pagination($current_page, $total_page,"admin.php?action=account&user&page=") ?>
            <?php }} ?>
        </div>
        
        <!-- Quản lý nhân viên -->
        <div id="collapseThree" class="collapse text-center  <?php if(isset($_GET['staff'])) echo 'show' ?>" data-parent="#accordion">
            <div class="form-group d-flex justify-content-center mt-4">
                <input class="form-control w-50" id="Input_s" type="text" placeholder="Nhập thông tin nhân viên muốn tìm..">
            </div>
            <div class="d-flex justify-content-center my-4">
                <table class="col-md-12 table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Mã NV</td>
                            <td>Tên</td>
                            <td>Email</td>
                            <td>SĐT</td>
                            <td>Chức vụ</td>
                            <td>Ngày vào</td>
                            <td width="50px">Trạng thái</td>
                            <td width="50px">Phân quyền</td>
                            <td width="50px">Xóa</td>
                        </tr>
                    </thead>
                    <tbody id="Table_s">
                        <?php
                            // Tính tổng số cột
                            $stmt=$conn->prepare('SELECT count(id_user) AS total_record FROM user');
                            $stmt->execute();
                            $row=$stmt->fetch();
                            $total_record=$row['total_record'];
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
                            $stmt=$conn->prepare('SELECT * FROM staff LIMIT :start, :limit');
                            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                            $stmt->execute();
                            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){
                                $id_staff=$row['id_staff'];
                                
                                $stmt_s=$conn->prepare('SELECT id_per FROM staff_per WHERE id_staff=:id_staff');
                                $stmt_s->execute(['id_staff' => $id_staff]);
                                $result_s=$stmt_s->fetchAll(PDO::FETCH_ASSOC);
                                foreach($result_s as $row_s){
                                    $arr_per[]=$row_s['id_per'];
                                }
                        ?>
                        <tr>
                            <td height="35px"><?php echo $row['id_staff'] ?></td>
                            <td><?php echo $row['staffname'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo role_staff($arr_per) ?></td>
                            <td><?php echo date_format(date_create($row['created_at'], new DateTimeZone('Asia/Bangkok')),"d-m-Y") ?></td>
                            <td><a href="lib/admin/process/change_status_staff.php?id_staff=<?php echo $row['id_staff'] ?>&status=<?php echo $row['status'] ?><?php if(isset($_GET['page'])){ echo '&page='.$page;} ?>" class="text-success <?php if($row_s['id_per']==1) echo 'isDisabled' ?>"><?php echo status_active($row['status']) ?></a></td>
                            <td><a href="" class="text-primary <?php if($row_s['id_per']==1) echo 'isDisabled' ?>" data-toggle="modal" data-target="#<?php echo 'update'.$row['id_staff'] ?>" data-toggle="tooltip" title="Cập nhật chức vụ nhân viên"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                            <td><a href="lib/admin/process/del_staff.php?id_staff=<?php echo $row['id_staff'] ?>" class="text-danger <?php if($row_s['id_per']==1) echo 'isDisabled' ?>" onclick="return confirmDel()"><i class="fa fa-trash-o px-1" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php unset($arr_per); } ?>
                    </tbody>
                </table>
            </div>
            <?php if($total_record > $limit){ ?>
                <!-- Tiến hành phân trang -->
                <?php pagination($current_page, $total_page,"admin.php?action=account&staff&page=") ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    // Khởi tạo tất cả các form cập nhật chức vụ nhân viên
    $query="SELECT id_staff, licensed FROM staff_per WHERE id_per != '1'";
    $stmt=$conn->prepare($query);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){ 
        $id_staff=$row['id_staff'];
        $licensed=$row['licensed'] ?>

    <!-- Cập nhật chức vụ nhân viên -->
    <div class="modal" id="<?php echo 'update'.$id_staff ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title">Cập nhật chức vụ nhân viên</h6>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="col-md-12 modal-body text-center">
                    <form action="lib/admin/process/update_staff_per.php?id_staff=<?php echo $id_staff ?>&licensed=<?php echo $licensed ?><?php if(isset($_GET['page'])){ echo '&page='.$page;} ?>" method="POST">
                    <div class="form-group pl-5">
                    <?php 
                        // Đánh checked vào các ô là chức vụ hiện tại của nhân viên
                        $stmt=$conn->prepare('SELECT id_per FROM staff_per WHERE id_staff=:id_staff AND id_per <> "1"');
                        $stmt->execute(['id_staff' => $id_staff]);
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row){
                            $_SESSION['permission'][]=$row['id_per'];
                        }
                        $stmt=$conn->prepare('SELECT * FROM permission WHERE id_per <> "1" AND id_per <> "7"');
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row){ 
                            ?>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" <?php if(in_array($row['id_per'], $_SESSION['permission'])) echo 'checked="checked"' ?> id="<?php echo $id_staff.$row['id_per'] ?>" name="id_per['<?php echo $row['id_per'] ?>]'" value="<?php echo $row['id_per'] ?>">
                                <label class="custom-control-label" for="<?php echo $id_staff.$row['id_per'] ?>"><?php echo $row['name_per'] ?></label>
                            </div>
                        <?php } unset($_SESSION['permission']) ?>
                    </div>
                    <input type="submit" name="submit" class="btn btn-danger btn-sm px-5 py-2" value="Cập nhật">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- chọn -->
<script src="js/select.js" type="text/javascript"></script>
<?php } ?>