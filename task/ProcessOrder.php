
<?php

include('functions.php');


// did the user provide a UserName via POST?
if(isset($_POST['UserName']))
{
	$UserName = trim($_POST['UserName']);
	
	// do they have items in their cart?
	if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != "")
	{
		$dbh = connectToDatabase();
		
		// first check the user name is valid, if so fetch their customer ID
		// COLLATE NOCASE tells SQLite to do a case insensitive match.
		$statement1 = $dbh->prepare('SELECT CustomerID FROM Customers WHERE UserName = ? COLLATE NOCASE; ');
		$statement1->bindValue(1,$UserName);
		$statement1->execute();
		
		// did we find a match??
		if($row = $statement1->fetch(PDO::FETCH_ASSOC))
		{
			// get their CustomerID
			$customerID = $row['CustomerID'];
			
			// now we want to add an order to the orders list.
			$statement2 = $dbh->prepare('INSERT INTO Orders (TimeStamp, CustomerID) VALUES (?,?); ');
			$statement2->bindValue(1,time());
			$statement2->bindValue(2,$customerID);
			$statement2->execute();			
			
			// get the OrderID of the order we just added to the database.
			$orderID = $dbh->lastInsertId();
			
			// now that we know the orderID, we can add the products in the users cart into the database
			$statement3 = $dbh->prepare('INSERT INTO OrderProducts (OrderID, ProductID, Quantity) VALUES (?,?,1); ');
			$statement3->bindValue(1,$orderID);
			
			// convert the comma separated list into an array so we can loop over it.
			$cartItems = explode(",", $_COOKIE['ShoppingCart']);
			
			// loop over each item in the shopping cart array.
			foreach($cartItems as $item)
			{
				$statement3->bindValue(2,$item);
				$statement3->execute();			
			}
			
			// order complete!, empty the cart and show them the order details
			deleteCookie("ShoppingCart");
			setCookieMessage("Order Success!!");
			redirect("ViewOrderDetails.php?OrderID=$orderID");
		}
		else 
		{
			setCookieMessage("User name Not found!");
			redirect("ViewCart.php");
		}	
	}
	else 
	{
		setCookieMessage("You don't have any items in your cart!");
		redirect("ViewCart.php");
	}
}
else 
{
	echo "System Error: username not provided in ProcessOrder.php.";
}



