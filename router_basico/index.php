<?php  


$request = $_SERVER['REQUEST_URI'];
echo $router = str_replace("/router_basicoo", "", $request);

$id = "";
$arr = explode("/", $router);
if (isset($arr[2])) {
	$id = $arr[2];
}

if($router === "/" || $router === "/home"){
	require 'home.php';
}elseif($router === "/about"){
	require 'about.php';
}elseif($router === "/services"){
	require 'services.php';
}elseif($router === "/products" || preg_match("/products\/[0-9]/i", $router)){
	// $id = "";
	// $arr = explode("/", $router);
	// if (isset($arr[2])) {
	// 	$id = $arr[2];
	// }
	require 'products.php';
}else{
	require '404.php';
}



// function dd($value){

// 	echo "<pre>";
// 	var_dump($value);
// 	echo "</pre>";

// 	die();

// }

// dd($_SERVER);
// this is the home page 
// ["REQUEST_URI"]=>
//  string(21) "/php_router/index.php"
//echo $_SERVER['REQUEST_URI']; saber url actual

?>