<div class="col-md-5 text-center m-auto">
    <script type="text/javascript">        
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }

        <?php
            // Thông báo lỗi
            if(isset($_COOKIE["error"])){
        ?>
        $(function () {
            Command: toastr["error"]("<?php echo $_COOKIE["error"]; ?>")
        })
        <?php }
            // Thông báo thành công
            if(isset($_COOKIE["success"])){
        ?>
        $(function () {
            Command: toastr["success"]("<?php echo $_COOKIE["success"]; ?>")
        })
        <?php } 
            // Thông báo cảnh báo
            if(isset($_COOKIE["warning"])){
        ?>
        $(function () {
            Command: toastr["warning"]("<?php echo $_COOKIE["warning"]; ?>")
        })
        <?php } ?>
    </script>
</div>