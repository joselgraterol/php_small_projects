<?php
include 'db.php';
  
if (isset($_POST['add_product'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);

   //convert the value to a integer since PHP treats data retrieved from the database as strings
   $category_id = (int)$_POST['category'];

   $insert_product = $conn->prepare("INSERT INTO `products`(name, price, category_id) VALUES(?,?,?)");
   $insert_product->execute([$name, $price, $category_id]);


}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>products</title>
</head>
<body>
   <?php include "nav.php"; ?>
	<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post">
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>

         <div class="inputBox">
            <select name="category" class="box" required>
		         <option value="" selected disabled>-- select category* </option>
               <?php  

               $select_categories = $conn->prepare("SELECT * FROM `categories`"); 
               $select_categories->execute();
               if($select_categories->rowCount() > 0){
                  while($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)){
               ?>

		         <option value="<?= $fetch_category['id']; ?>"><?= $fetch_category['name']; ?></option>

               <?php  
                  } 
               }
               ?>
      		</select>
         </div>

         
        
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>




</body>
</html>