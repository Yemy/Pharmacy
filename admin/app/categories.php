<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['btn_save']))
{
	$stmt = $conn->prepare("INSERT INTO `medicine_category`( `name`,`short_name`, `added_date`) VALUES (:name,:short_name, :added_date)");
	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':short_name', $_POST['short_name']);
	$stmt->bindParam(':added_date', date('Y-m-d'));	
	$stmt->execute();

	$_SESSION['reply'] = "003";
	header("location:../categories");
}
if(isset($_POST['btn_edit']))
{
	$stmt = $conn->prepare("UPDATE medicine_category SET name=:name,short_name=:short_name WHERE id=:id");
	$stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':short_name', $_POST['short_name']);
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->execute();
	$_SESSION['reply'] = "004";
	header("location:../categories");
}
if(isset($_GET['id']))
{
	//$stmt = $conn->prepare("DELETE FROM medicine_category WHERE id = :id");
	$stmt = $conn->prepare("UPDATE medicine_category SET delete_status=1 WHERE id=:id");
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
