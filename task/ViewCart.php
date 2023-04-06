<?php 

include('functions.php');

//cookie messages
$cookieMessage = getCookieMessage();

?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/Your Cart</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>

<body>
	<div class = "page-wrap">

		<div id="logo">
			<a href= "logo.jpg">
			<img src="logo.jpg" alt="Logo" width="50px" height="50px">
			</a> &nbsp; &nbsp;
		</div>

		<div id="logo-text">
			<h4>ELITE SHOPPING</h4>
		</div>

		<br>
		<br>
		<br>
		
		<div id="header">
			<h1>Your Cart details!</h1>
		</div>

	  <div id = "navbar">
	    <ul>
	      <li><a href="Homepage.php">Home</a></li>
	      <li><a href="ProductList.php">Products</a></li>
	      <li><a href="ViewCart.php">Cart</a></li>
	      <li><a href="SignUp.php">Sign Up</a></li>
	      <li><a href="index.php">Log Out</a></li>
	    </ul>
	  </div>

		<?php

		// does the user have items in the shopping cart?
		if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != '')
		{
			// the shopping cart cookie contains a list of productIDs separated by commas
			// we need to split this string into an array by exploding it.
			$productID_list = explode(",", $_COOKIE['ShoppingCart']);
			
			// remove any duplicate items from the cart. although this should never happen we 
			// must make absolutely sure because if we don't we might get a primary key violation.
			$productID_list = array_unique($productID_list);
			
			//connect to database
			$dbh = connectToDatabase();

			// create a SQL statement to select the product and brand info about a given ProductID
			// this SQL statement will be very similar to the one in ViewProduct.php
			$statement = $dbh->prepare('SELECT * FROM Products INNER JOIN Brands ON Brands.BrandID = Products.BrandID
				WHERE Products.ProductID = ?' );

			$totalPrice = 0;
			
			// loop over the productIDs that were in the shopping cart.
			foreach($productID_list as $productID)
			{
				
				  // bind the first question mark to the productID in the shopping cart.
					$statement->bindValue(1,$productID);
					$statement->execute();
				
					// did we find a match?
					if($row = $statement->fetch(PDO::FETCH_ASSOC))
					{				
						
						// display the details here.
						$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
						$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
						$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8'); 
						$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8'); 

						// output the data in a div with a class of 'productBox' we can apply css to this class.
						echo "<div class = 'productBox'>";	
						echo "$BrandName <br/>";
						echo "$Description <br/>";
						echo "$$Price <br/>";
						echo "<img src = '../IFU_Assets/ProductPictures/$productID.jpg' alt= 'productID' /> <br/>";
						echo "<a href='https://www.$BrandName.com.au'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a><br/>";
						echo "</div>";
						echo "<br/>";
						
						$totalPrice = $totalPrice + $Price;
					}
			}
			
			echo "<div id='alignment'>";
			echo "<div id='blackFont'>";
			echo "<p>The total price of all items is: ";
			echo "$$totalPrice<br/><br/>";
			echo "</div>";

			
			//cookie message
			echo "<div id='errorCookie'>";
			echo "<br/><br/><p>$cookieMessage</p>";
			echo "</div>";
			
			
			echo "<form action = 'ProcessOrder.php' method = 'POST'>";
				
				//this input tag MUST have its name attribute set to 'UserName'
				echo "Enter your username to proceed with the order: ";
				echo "<input type='text' name='UserName' placeholder='username' />";
				
				//submit button
				echo "<input type='submit' value = 'Confirm Order' />";
				echo "<br/>";
				echo "<br/>";

			echo "</form>";
				
			echo "<form action = 'EmptyCart.php' method = 'POST'>";
				echo "<input type = 'submit' name = 'EmptyCart' value = 'Empty Shopping Cart' id = 'EmptyCart' />";
			echo "&emsp;&emsp;";
			echo "<form action = 'ProductList.php'>";
				echo "<input type = 'submit' value = 'Continue Shopping' /><br/><br/>";	
			echo "</form>";		
			echo "</div>";		
		}

		else
		{
			//cookie message
			echo "<div id=cookie>";
			echo "<br/><p>$cookieMessage <br/></p>";
			echo "</div>";
			echo "<div id=thickFont>";
			echo "<p>You Have no items in your cart!</p><br/><br/>";
			echo "</div>";
			echo "<div id=alignment>";
			echo "<form action = 'ProductList.php'>";
				echo "<input type = 'submit' value = 'Continue Shopping' /><br/><br/>";	
			echo "</form>";	
			echo "</div>";
		}

		?>
	</div>

	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>

</body>
</html>
