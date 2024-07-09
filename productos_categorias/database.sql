CREATE TABLE `categories` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL
);



CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `price` INT NOT NULL,
  `category_id` INT,
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
);

-- ON DELETE SET NULL: This clause in the foreign key constraint specifies that when a category is deleted, the category_id of associated products will be set to NULL instead of deleting the products themselves.




-- I AM NOT USING THIS ONE IN THIS PROJECT

-- The code you provided attempts to delete a category directly, but foreign key constraints prevent this if there are products referencing that category. There are two main approaches to handle this scenario:

--   Enforce Referential Integrity with ON DELETE CASCADE:

-- This approach modifies the foreign key definition in the products table. You can achieve this by altering the table structure using phpMyAdmin or a similar tool. Here's the modified products table definition:


CREATE TABLE `products` (
`id` INT(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`name` VARCHAR(100) NOT NULL,
`price` INT(10) NOT NULL,
`category_id` INT(100) NOT NULL,
FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
);

-- Use code with caution.
-- content_copy
-- The ON DELETE CASCADE clause specifies that when a category is deleted, all corresponding products referencing that category will also be deleted automatically.





