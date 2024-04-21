

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<?php  

require_once 'controller/UserController.php';

$controller = new UserController();
echo $controller->showUser();

?>
</body>
</html>