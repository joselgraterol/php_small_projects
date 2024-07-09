<?php  
include 'db.php';

if(isset($_GET['delete'])){

   $delete_id = (int)$_GET['delete'];
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   header('location:products.php');
}

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

<section class="products">

   <h1 class="heading">all products</h1>

   <div class="box-container">
    <?php
    // $select_products = $conn->prepare("SELECT p.*, c.name AS category_name FROM `products` p INNER JOIN `categories` c ON p.category_id = c.id");

//     You're absolutely right. The commented query (SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id) only retrieves products that have a valid category assigned (those with a matching category_id in the categories table). This excludes products with a category_id set to NULL.

// On the other hand, the uncommented query (SELECT * FROM products) retrieves all rows from the products table, regardless of the category_id value. This includes products with both valid and NULL category_id.

// Here's a breakdown of why the commented query excludes products with NULL category_id:

// INNER JOIN: This type of join only includes rows where the join condition is met (in this case, p.category_id = c.id).
// Missing Match for NULL: Products with category_id as NULL won't find a corresponding row in the categories table during the join. This effectively excludes them from the results because no matching row exists in the joined table.
// The uncommented query retrieves all products because it doesn't rely on a join with the categories table. It simply selects all columns (*) from the products table, including those with NULL category_id.





    $select_products = $conn->prepare("SELECT p.*, c.name AS category_name FROM `products` p LEFT JOIN `categories` c ON p.category_id = c.id");

    // LEFT JOIN: This type of join includes all rows from the left table (products) and matching rows from the right table (categories). If there's no match in the right table (for products with category_id as NULL), it still includes those rows from the left table with NULL values for the joined columns (category details).

    $select_products->execute();

    if ($select_products->rowCount() > 0) {
        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div>
                <p><?= $fetch_product['name']; ?></p>
                <p><?= $fetch_product['price']; ?></p>
                <p><?= $fetch_product['category_name'] ?: 'No Category'; ?></p> <!-- Display category name -->
                <div class="flex-btn">
                <a href="update_product.php?update=<?= $fetch_product['id']; ?>" class="option-btn">update</a>
                <a href="all_products.php?delete=<?= $fetch_product['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                </div>
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