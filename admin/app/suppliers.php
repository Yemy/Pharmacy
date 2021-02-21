<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['btn_save']))
{
	$stmt = $conn->prepare("INSERT INTO `suppliers`(`name`, `address`, `telephone`, `fax`, `info`, `added_date`) VALUES (:name,:address,:telephone,:fax,:info, :added_date)");
	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':address', $_POST['address']);
	$stmt->bindParam(':telephone', $_POST['telephone']);
	$stmt->bindParam(':fax', $_POST['fax']);
	$stmt->bindParam(':info', $_POST['info']);
	$stmt->bindParam(':added_date', date('Y-m-d'));	
	$stmt->execute();

	$_SESSION['reply'] = "003";
	header("location:../suppliers");
}
if(isset($_POST['btn_edit']))
{
	$stmt = $conn->prepare("UPDATE suppliers SET name=:name,address=:address,telephone=:telephone,fax=:fax,info=:info WHERE id=:id");
	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':address', $_POST['address']);
	$stmt->bindParam(':telephone', $_POST['telephone']);
	$stmt->bindParam(':fax', $_POST['fax']);
	$stmt->bindParam(':info', $_POST['info']);
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->execute();
	$_SESSION['reply'] = "004";
	header("location:../suppliers");
}
if(isset($_GET['id']))
{
	//$stmt = $conn->prepare("DELETE FROM suppliers WHERE id = :id");
	$stmt = $conn->prepare("UPDATE suppliers SET delete_status=1 WHERE id=:id");
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
