<?php 

include('functions.php');

// Did the user click the buy button AND did they provide a ProductID?
if(!isset($_POST['BuyButton']))
{
	echo "BuyButton not provided, the submit button should be named BuyButton and the form method should be POST"; 
}
elseif(!isset($_GET['ProductID']))
{
	echo "ProductID not provided, make sure you have passed the ProductID in the URL"; 
}
else 
{	

	$productToBuy = trim($_GET['ProductID']);
	// add the product to the shopping cart cookie
	// if the cookie is defined AND not an empty string
	if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != "")
	{
		// and then add the $productToBuy to the end of the comma separated list.
		$CartList = $_COOKIE['ShoppingCart'];
		$newCartList = "$CartList,$productToBuy";
		
		// setcookie(...);
		setcookie("ShoppingCart", $newCartList, time() + 3600*8);
	}
	else 
	{
		// setcookie(...);
		setcookie("ShoppingCart", $productToBuy, time() + 3600*8);
	}
	
	// redirect the user back to ViewProduct.php 
	redirect("ViewProduct.php?ProductID=$productToBuy");
}
