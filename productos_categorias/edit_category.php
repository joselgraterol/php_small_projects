<?php  
include 'db.php';

if(isset($_POST['update'])){

   $pid = (int)$_POST['pid'];
   $name = filter_var($_POST['category-name'], FILTER_SANITIZE_STRING);
   

   $update_category = $conn->prepare("UPDATE `categories` SET name = ? WHERE id = ?");
   $update_category->execute([$name, $pid]);

   

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

   <h1 class="heading">update category</h1>

   <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $select_categories = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
         $select_categories->execute([$update_id]);
         if($select_categories->rowCount() > 0){
            while($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)){
       
   ?>
   <form action="" method="post">
      <input type="hidden" name="pid" value="<?= $fetch_category['id']; ?>">
     
      
      <span>update name</span>
      <input type="text" name="category-name" class="box" maxlength="100" placeholder="enter category name" value="<?= $fetch_category['name']; ?>">
         <input type="submit" name="update" class="btn" value="update">
         <a href="categories.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   }
   
   ?>

</section>

   
</body>
</html>