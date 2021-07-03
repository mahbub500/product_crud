<?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$id= $_GET['id'] ?? null;
 if(!$id){
 	header('location: product.php');
 	exit;
 }

$statement = $pdo->prepare('SELECT * FROM product_crud WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
$product= $statement->fetch(PDO::FETCH_ASSOC);

echo "<pre>";
var_dump ($product);
echo "</pre>";

$errors=[];
$title = $product['Title'];
$descriptiion = $product['descriptiion'];
$price = $product['price'];
if ($_SERVER['REQUEST_METHOD']=='POST') {
		$title = $_POST['title'];
		$descriptiion = $_POST['descriptiion'];
		$price = $_POST['price'];
		// $date = date("d-m-y h:i:s");
		// $date = $_POST['date'];
	if (!$title) {
		$errors[] = 'Title Required<br>';
	}
	if (!$price) {
		$errors[] = 'Price Required<br>';
	}
// make images directory
	if (!is_dir('images')) {
		mkdir('images');
	}
	if (empty($errors)) {
		$image = $_FILES['image'] ?? null;
 		$imagePath=$product['image'];
 		// insert Image
 		if($image && $image['tmp_name']){
		// unlink image
 		if ($product['image']) {
 			unlink($product['image']);
 		}
 		$imagePath = 'images/'.randomString(8).'/'.$image['name'];
	 	mkdir(dirname($imagePath));
	 	move_uploaded_file($image['tmp_name'],$imagePath);
	 	// insert to Database
 	} 	
 $statement =$pdo->prepare("UPDATE `product_crud` SET `Title` = :title, `descriptiion` = :descriptiion,`image`= :image,`price`=:price WHERE `product_crud`.`ID` = :id");

 // UPDATE `product_crud` SET `Title` = 'Redmi Note 10 Updat', `descriptiion` = 'fdfsf ghjtjtyjjyt' WHERE `product_crud`.`ID` = 54;
		$statement->bindValue(':title',$title);
		$statement->bindValue(':descriptiion',$descriptiion);
		$statement->bindValue(':image',$imagePath);
		$statement->bindValue(':price',$price);
		$statement->bindValue(':id',$id);
		$statement->execute();
		header('location: product.php');

	}
}


function randomString($n){
	$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$str = '';
	for ($i= 0; $i<$n; $i++){
		$index = rand(0,strlen($characters)-1);
		$str .= $characters[$index];
	}
	return $str;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crate Product</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<?php if (!empty($errors)):?>
	<?php foreach ($errors as  $error):?>
		<?php echo $error ?>
	<?php endforeach; ?>
<?php endif; ?>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<p><a href="Product.php" class="btn btn-outline-primary mt-2">Go To All Product</a></p>
			<h3>Update Product <?php echo $product['Title']; ?> </h3>
			<form action="" method="post" enctype="multipart/form-data">
				<?php if ($product['image']):?>
				<img src="<?php echo $product['image'] ?>" class="mb-3" style="height: 107px; width: 161px;"alt="image">
					
				<?php endif; ?>
			<div class="form-floating mb-3">
  				<input type="text" name="title" value="<?php echo $title ?>" placeholder="title here" class="form-control" >
  				<label >Enter Your Product Title</label>
			</div>
			<div class="form-floating mb-3">
			  <textarea class="form-control" name="descriptiion" placeholder="Leave a comment here" id="floatingTextarea"> <?php echo $descriptiion; ?> </textarea>
			  <label for="floatingTextarea">Product Description</label>
			</div>
			<div class="mb-3">
			  <label for="formFile" class="form-label">Upload Your Image </label>
			  <input class="form-control" name="image" type="file" id="formFile">
			</div>

			<div class="form-floating mb-3">
				  <input type="text" name="price" value=" <?php echo $price ?>" step=".01" class="form-control"  placeholder="Price Please">
				  <label >Product Price</label>
			</div>
			
			<div class="form-floating mb-3">
				  <input type="submit"  class="form-control btn btn-outline-primary text-center" value="UPDATE"  >
			</div>
			</form>
		</div>
	</div>
</div>
	
</body>
</html>