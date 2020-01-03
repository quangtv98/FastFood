<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eating machine</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/my.css" />
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/gijgo.min.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="css/toastr.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script src="js/toastr.js" type="text/javascript"></script>
    <script src="js/popper.min.js" type="text/javascript"></script>
    <script src="js/gijgo.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    
    <!-- Xác nhận bắt đầu chương trình khuyến mãi và sẽ kết thúc chương trình cũ -->
    <script type="text/javascript">
        function confirmEnd() {
            return confirm("Hãy đảm bào rằng các chương trình đang diễn ra đã kết thúc !!!")
        }
    </script>
    <!-- Xác nhận thao tác xóa  -->
    <script type="text/javascript">
        function confirmDel() {
            return confirm("Bạn chắc chắn muốn xóa !!!")
        }
    </script>
    <!-- Xác nhận thao tác thanh toán  -->
    <script type="text/javascript">
        function confirmPayment() {
            return confirm("Bạn chắc chắn thông tin trên chính xác ?\nVà nhận hàng theo địa chỉ trên !!!")
        }
    </script>
    <!-- Hàm bổ trợ của boostrap -->
    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>  
    
    <script src="js/toastr.min.js"></script>
</head>