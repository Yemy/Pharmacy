<?php
session_start();
$_SESSION['logged'] = "0";
$_SESSION['role'] = "";
session_destroy();
header("location:./");
?>