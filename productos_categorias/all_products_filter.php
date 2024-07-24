<?php  
include 'db.php';


// filter products

// Check if the filter form is submitted
if (isset($_POST['filter_products'])) {
  $category_id = (int)$_POST['category_id']; // Sanitize and convert to integer
} else {
  $category_id = null; // Show all products if no category selected
}

// Build the query based on the category ID
$sql = "SELECT p.*, c.name AS category_name FROM `products` p INNER JOIN `categories` c ON p.category_id = c.id";

if ($category_id) {
  $sql .= " WHERE p.category_id = ?";
}

$stmt = $conn->prepare($sql);

if ($category_id) {
  $stmt->execute([$category_id]);
} else {
  $stmt->execute();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now you have the filtered products in $products array


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>all products</title>
</head>
<body>

<?php include "nav.php"; ?>

<form action="" method="post">
  <label for="category_filter">Filter by Category:</label>
  <select name="category_id" id="category_filter">
    <option value="">All Categories</option>
    <?php

    $select_categories = $conn->prepare("SELECT * FROM `categories`");
    $select_categories->execute();
    if ($select_categories->rowCount() > 0) {
      while ($fetch_category = $select_categories->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <option value="<?= $fetch_category['id']; ?>"><?= $fetch_category['name']; ?></option>
        <?php
      }
    }
    ?>
  </select>
  <input type="submit" value="Filter" name="filter_products">
</form>



<section class="products">

   <h1 class="heading">all products</h1>

    <div class="box-container">
    <?php
      if ($products) {
        foreach ($products as $fetch_product) {
    ?>
        <div>
            <p><?= $fetch_product['name']; ?></p>
            <p><?= $fetch_product['price']; ?></p>
            <p><?= $fetch_product['category_name']; ?></p>
            <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye">ver</a> 
        </div>
    <?php
        }
      } else {
        echo '<p class="empty">No products found!</p>';
      }
    ?>
</div>

   

</section>

</body>
</html>