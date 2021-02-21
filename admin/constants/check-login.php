<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

$myemail = $_SESSION['email'];
$myvataor = $_SESSION['avator'];

}else{

header("location:../");

}

?>