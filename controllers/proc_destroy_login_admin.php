<?php
	session_start();
	session_destroy();
	unset ( $_SESSION['sessA'] );
	unset ( $_SESSION['userId'] );
	unset ( $_SESSION['userName'] );
	unset ( $_SESSION['perfil'] );
	header('Location: ../form_login_store.php');
?>