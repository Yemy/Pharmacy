<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');

$myemail = $_POST['email'];
$new_avatar  = addslashes(file_get_contents($_FILES['image']['tmp_name']));
$old_avatar = $_POST['current'];

if ($new_avatar == null) {

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	
/*$stmt = $conn->prepare("SELECT  email FROM tbl_students WHERE email = :email");
$stmt->bindParam(':email', $myemail);
$stmt->execute();
$result = $stmt->fetchAll();
$rec = count($result);

if ($rec > 0) {

$_SESSION['reply'] = "012";
header("location:../account");

}else{*/

$stmt = $conn->prepare("UPDATE tbl_admin SET email = :email");
$stmt->bindParam(':email', $myemail);
$stmt->execute();

$_SESSION['email'] = $myemail;

$_SESSION['reply'] = "022";
header("location:../account");

//}

					  
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{


try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	
/*$stmt = $conn->prepare("SELECT  email FROM tbl_students WHERE email = :email");
$stmt->bindParam(':email', $myemail);
$stmt->execute();
$result = $stmt->fetchAll();
$rec = count($result);

if ($rec > 0) {

$_SESSION['reply'] = "012";
header("location:../account");

}else{*/

$new_file_name = ''.rand(10000,90000).'.png';
$target_dir = "../../assets/uploads/avatar/";
$target_file = '../../assets/uploads/avatar/'.$new_file_name.'';
$unlink = '../../assets/uploads/avatar/'.$old_avatar.'';


if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

if (!unlink($unlink))
  {

  }
else
  {

  }

//}

$stmt = $conn->prepare("UPDATE tbl_admin SET email = :email, avator = :avator");
$stmt->bindParam(':email', $myemail);
$stmt->bindParam(':avator', $new_file_name);
$stmt->execute();

$_SESSION['email'] = $myemail;
$_SESSION['avator'] = $new_file_name;

$_SESSION['reply'] = "022";
header("location:../account");

}

					  
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


//do not toouch
}

}else{
	header("location:../");
}

?>
