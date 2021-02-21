<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['btn_save']))
{
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$role='users';
	$stmt = $conn->prepare("INSERT INTO `tbl_admin`( `email`,`group_id`, `role`,`login`) VALUES (:email,:group_id, :role,:login)");
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':group_id', $_POST['group_id']);
	$stmt->bindParam(':role',$role);	
	$stmt->bindParam(':login',$password);
	$stmt->execute();

	$_SESSION['reply'] = "003";
	header("location:../users");
}
if(isset($_POST['btn_edit']))
{
	$stmt = $conn->prepare("UPDATE tbl_admin SET email=:email,group_id=:group_id WHERE id=:id");
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':group_id', $_POST['group_id']);
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->execute();
	$_SESSION['reply'] = "004";
	header("location:../users");
}
if(isset($_GET['id']))
{
	$stmt = $conn->prepare("DELETE FROM tbl_admin WHERE id = :id");
	//$stmt = $conn->prepare("UPDATE medicine_category SET delete_status=1 WHERE id=:id");
	$stmt->bindParam(':id', $_GET['id']);
	$stmt->execute();
}


					  
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{

header("location:../");

}

?>
