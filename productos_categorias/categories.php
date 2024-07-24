<?php
include 'db.php';
  
if (isset($_POST['add_category'])) {

	$name = filter_var($_POST['category-name'], FILTER_SANITIZE_STRING);
  $name = trim($name);  // Remove leading/trailing whitespaces
  $name = strtolower($name);  // Convert to lowercase
  $name = preg_replace('/\s{2,}/', ' ', $name);  // Replace multiple spaces with a single space

 	$insert_category = $conn->prepare("INSERT INTO `categories`(name) VALUES(?)");
  $insert_category->execute([$name]);

  echo "<script>
          alert('categoria guardada');
          window.location = 'categories.php';
          </script>";

}

if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];

    $delete_category = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
    $delete_category->execute([$delete_id]);
    echo "<script>
            alert('categoria eliminada');
            window.location = 'categories.php';
            </script>";
    
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>categorias</title>
</head>
<body>

  <?php include "nav.php"; ?>

	<!-- formulario -->

        <div class="form-popup">
            <div class="form-popup-content">
              <button class="close">
                  <span>&times;</span>
              </button>   
          
              <h3>Añadir Categoria</h3>
              <form id="form" autocomplete="off" class="grid-card-form" method="POST">
                
          
                <div class="inputs">
                
                  <label for="category-name">Nombre:</label>
                  <input type="text" id="category-name" name="category-name" required>
          
                  <div class="form-actions">
                    <button id="volver" type="button">Cancelar</button>
                    <button id="submit-btn" type="submit" name="add_category" value="enviar">Añadir</button>
                  </div>
                </div>    
              </form>
          
            </div>
          </div>

<!-- formulario ends -->


<div class="box-container">

   <?php
     $select_categories = $conn->prepare("SELECT * FROM `categories`"); 
     $select_categories->execute();
     if($select_categories->rowCount() > 0){
      while($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)){
   ?>
    <div>
      <h3><?php echo $fetch_category['name'] ?></h3>
      <div class="info-btn">
        <!-- <a href="edit_category.php?update=<?php echo $fetch_category['id']?>">edit</a> -->
        <a href="edit_category?update=<?php echo $fetch_category['id']?>">edit</a>
        <a href="categories.php?delete=<?php echo $fetch_category['id']?>" onclick="return confirm('seguro de que quieres borrar esta categoria?')">delete</a>
                              
      </div>
    </div>
   <?php
      }
   }else{
      echo '<p class="empty">no products found!</p>';
   }
   ?>

   </div>

</body>
</html>