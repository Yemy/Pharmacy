<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST["btn_submit"]))
{
  extract($_POST);
  $stmt = $conn->prepare("insert into groups(name,description)values('$assign_name','$description')");
    $stmt->execute();
  $last_id=$conn->lastInsertId();
$id=$last_id;
$checkItem = $_POST["checkItem"];
//print_r($_POST);
 $a = count($checkItem);  
for($i=0;$i<$a;$i++){
$stmt = $conn->prepare("insert into permission_role(permission_id,role_id)values('$checkItem[$i]','$id')");
    $stmt->execute();

       }
       $_SESSION['reply'] = "003";
    header("location:../roles");
}

if(isset($_POST["btn_edit"]))
{
  extract($_POST);
     $stmt = $conn->prepare("delete  from permission_role where role_id='".$_POST['id']."'");
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE groups set name='$assign_name',description='$description' where id='".$_POST['id']."'");
    $stmt->execute();

$checkItem = $_POST["checkItem"];
//print_r($_POST);
 $a = count($checkItem);  
for($i=0;$i<$a;$i++){
 $id = $_POST['id'];

         $sql="insert into permission_role(permission_id,role_id)values('$checkItem[$i]','$id')";
          $qq = $conn->query($sql);
        
       }
      $_SESSION['reply'] = "004";
    header("location:../roles");
}
}
?>