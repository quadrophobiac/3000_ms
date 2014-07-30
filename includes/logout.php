<?php
session_start();
// echo var_dump($_SESSION); // uncomment for debug
session_destroy();
header('Location: ../index.html');
// utilise below if employing different php files that require session destory and redirect
//if($_SERVER["REQUEST_METHOD"] == "GET"){
//	$url = $_GET['dest'];
// 	header('Location: '.$url.'.php');
// }
?>