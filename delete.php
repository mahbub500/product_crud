<?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $id= $_POST['id'] ?? null;
 if(!$id){
 	header('location: product.php');
 	exit;
 }
$statement =$pdo->prepare('DELETE FROM product_crud WHERE ID = :id');
$statement->bindValue(':id',$id);
$statement->execute();
 	header('location: product.php');

 // echo '<pre>';
 // var_dump($id);
 ?>