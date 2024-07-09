<?php  
include 'db.php';

if(isset($_POST['update'])){

   $pid = (int)$_POST['pid'];
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
   $category_id = (int)$_POST['category'];
   

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, category_id = ? WHERE id = ?");
   $update_product->execute([$name, $price, $category_id, $pid]);

   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>



<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
     
      
      <span>update name</span>
      <input type="text" name="name" class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" name="price" class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">  
      <div class="flex-btn">
      	<div class="inputBox">
            <select name="category" class="box" required> 
               	<?php  

	    		$current_category_id = $fetch_products['category_id']; 
	        	if ($current_category_id == NULL) {
	        		echo '<option value="" selected disabled>-- select category* </option>';
	        	}

               	$select_categories = $conn->prepare("SELECT * FROM `categories`"); 
               	$select_categories->execute();
               	if($select_categories->rowCount() > 0){
                  while($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)){
               	?>

		         <option value="<?= $fetch_category['id']; ?>" <?php if($fetch_category['id'] == $current_category_id) echo "selected"; ?>><?= $fetch_category['name']; ?></option>

               	<?php  
                  } 
               	}
               	?>
      		</select>
        </div>
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>

   
</body>
</html>