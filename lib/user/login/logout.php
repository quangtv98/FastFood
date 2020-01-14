<?php
	session_start();
	if(isset($_SESSION['id_user'])){
        unset($_SESSION['id_user']);
		unset($_SESSION['username']);
		if(isset($_SESSION['cart'])){
			unset($_SESSION['cart']);
		}
		if(isset($_COOKIE['id_user'])){
			setcookie("id_user",$_SESSION['id_user'], time()-1,"/","",0);
			setcookie("username",$_SESSION['username'], time()-1,"/","",0);
		}
		header("location:../../../index.php?page=signin");
	}
?>