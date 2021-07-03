<?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM `product_crud` ORDER BY `crate_date` DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// var_dump($products);
 ?>


<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Product</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h3>All Product List</h3>
			<div class="btn-group" role="group" aria-label="Basic outlined example">
					  <a type="button" href="create.php" target="_blank" class="btn btn-outline-primary">Create</a>
			</div>
			<table class="table  table-striped"  >
			  <thead>
			    <tr>
			      <th scope="col">ID</th>
			      <th scope="col">Title</th>
			      <th scope="col">Description</th>
			      <th scope="col">Image</th>
			      <th scope="col">Price</th>
			      <th scope="col" >Crete Date</th>
			      <th scope="col" colspan="2">Create or Edit or Delete</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
				foreach($products as $i => $product ){ ?>
			    <tr>
			   
			    <td> <?php echo $i + 1 ; ?> </td>
				<td> <?php echo $product['Title']; ?> </td>
				<td style="height: 50px; width: 85px;">  <?php echo $product['descriptiion']; ?> </td>
				<td > <img style="height: 50px; width: 85px;"src="<?php echo $product['image']; ?>" alt="Image"  >  </td>
				<td> <?php echo $product['price']; ?> </td>
				<td> <?php echo $product['crate_date']; ?> </td>
				<td>
					<div class="btn-group" role="group" aria-label="Basic outlined example">
					  <a href=" update.php?id=<?php echo $product['ID']?>" type="button" class="btn btn-outline-warning">Update</a>
					 <form method="post" action="delete.php" >
					  	<input type="hidden" name="id" value="<?php echo $product['ID']?>">
					  	<button class="btn btn-outline-danger" type="submit"> Delete</button>

					  </form>
					</div>

				</td>
			    </tr>
			    <?php  	}	?>
				    
			    
			  </tbody>
			</table>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>





	
</body>
</html>