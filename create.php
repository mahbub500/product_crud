<?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// echo "<pre>";
// var_dump ($_FILES['image']);
// echo "</pre>";

// $statement = $pdo->prepare('SELECT * FROM `product_crud` ORDER BY `crate_date` DESC');
// $statement->execute();
// $products = $statement->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// var_dump($_GET);
$errors=[];
$title = '';
$price = '';
$descriptiion = '';



if ($_SERVER['REQUEST_METHOD']=='POST') {

$title = $_POST['title'];
$descriptiion = $_POST['descriptiion'];
$price = $_POST['price'];
// $date = date("d-m-y h:i:s");
$date = $_POST['date'];
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
 $imagePath='';
 if($image && $image['tmp_name']){
 	$imagePath = 'images/'.randomString(8).'/'.$image['name'];
 	mkdir(dirname($imagePath));
 	move_uploaded_file($image['tmp_name'],$imagePath);
 }
  


$statement =$pdo->prepare("INSERT INTO `product_crud` ( `Title`, `descriptiion`, `image`, `price`, `crate_date`) VALUES (:title,:descriptiion,:image,:price,:date)");
$statement->bindValue(':title',$title);
$statement->bindValue(':image',$imagePath);
$statement->bindValue(':descriptiion',$descriptiion);
$statement->bindValue(':price',$price);
$statement->bindValue(':date',$date);
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
			<h3>Create Product </h3>
			<form action="" method="post" enctype="multipart/form-data">
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
				  <input type="number" name="price" step=".01" class="form-control"  placeholder="Price Please">
				  <label >Product Price</label>
			</div>
			<div class="form-floating mb-3">
				  <input type="date"  class="form-control" name="date"  >
			</div>
			<div class="form-floating mb-3">
				  <input type="submit"  class="form-control btn btn-outline-primary text-center" value="SUBMIT"  >
			</div>
			</form>
		</div>
	</div>
</div>
	
</body>
</html>