<?php session_start();
ob_start();
session_destroy();
header("Location:http://".$_SERVER['SERVER_NAME']."/antigua/smartrecycler/login/login.php");
?>