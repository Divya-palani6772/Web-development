<!DOCTYPE HTML>
<html>

<head>
	<title>Elite/Order Receipt</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
	<meta charset="UTF-8" /> 
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
			<h1>Order Receipt</h1>
		</div>

		<div id = "navbar">
	        <ul>
	          <li><a href="empHome.php">Home</a></li>
	          <li><a href="CustomerList.php">Customers list</a></li>
	          <li><a href="OrderList.php">Orders list</a></li>
	          <li><a href="productTable.php">Products List</a></li> 
	          <li><a href="index.php">Log Out</a></li>
	        </ul>
	  </div>

		<?php

		// did the user provided an OrderID via the URL?
		if(isset($_GET['OrderID']))
		{
			$UnsafeOrderID = $_GET['OrderID'];
			
			include('functions.php');
			$dbh = connectToDatabase();
			
			// select the order details and customer details. (you need to use an INNER JOIN)
			// but only show the row WHERE the OrderID is equal to $UnsafeOrderID.
			$statement = $dbh->prepare('
				SELECT * 
				FROM Orders 
				INNER JOIN Customers ON Customers.CustomerID = Orders.CustomerID 
				WHERE OrderID = ? ; 
			');
			$statement->bindValue(1,$UnsafeOrderID);
			$statement->execute();
			
			// did we get any results?
			if($row1 = $statement->fetch(PDO::FETCH_ASSOC))
			{
				// Output the Order Details.
				$FirstName = makeOutputSafe($row1['FirstName']); 
				$LastName = makeOutputSafe($row1['LastName']); 
				$OrderID = makeOutputSafe($row1['OrderID']); 
				$UserName = makeOutputSafe($row1['UserName']); 
				$Address = makeOutputSafe($row1['Address']);
				$City = makeOutputSafe($row1['City']);
				$TimeStamp = makeOutputSafe(date("Y/m/d h:i A", $row1['TimeStamp']));

				// displaying content
				echo "<div class = 'productBox'>";
					echo "<h2>OrderID: $OrderID</h2>";
					echo "UserName: $UserName <br/>";
					echo "Customer Name: $FirstName $LastName <br/>";
					echo "Customer Address: $Address <br/>";
					echo "Customer City: $City <br/>";
					echo "Order time: $TimeStamp <br/>";
				echo "</div>";
				
				// this will involve three tables: OrderProducts, Products and Brands. //done
				$statement2 = $dbh->prepare('
					SELECT * FROM OrderProducts
					INNER JOIN Products ON OrderProducts.ProductID = Products.ProductID
					INNER JOIN Brands ON Products.BrandID = Brands.BrandID
					WHERE OrderID = ? ;
				');
				$statement2->bindValue(1,$UnsafeOrderID);
				$statement2->execute();
				
				$totalPrice = 0;
				echo "<div id='header'>";
				echo "<h2>Order Details:</h2>";
				echo "</div>";
				
				// loop over the products in this order. 
				while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
				{
					$ProductID = makeOutputSafe($row2['ProductID']); 
					$Description = makeOutputSafe($row2['Description']); 
					$Price = makeOutputSafe($row2['Price']);
					$Quantity = makeOutputSafe($row2['Quantity']);
					$BrandID = makeOutputSafe($row2['BrandID']);
					$BrandName = makeOutputSafe($row2['BrandName']);

					//displaying content
					echo "<div class ='productBox'>";	
						echo "$BrandName <br/>";
						echo "$Description <br/>";
						echo "$$Price <br/>";
						echo "<a href='ViewProduct.php?ProductID=$ProductID'><img src = '../IFU_Assets/ProductPictures/$ProductID.jpg' alt= 'productID' /></a><br/>";
						echo "<a href='https://www.$BrandName.com.au'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a><br/>";
					echo "</div>";
									
					$Price = $Price * $Quantity;
					$totalPrice = $totalPrice + $Price;
				}		
				
				//displaying totalprice
				echo "<br/>";
				echo "<div id='alignment'>";
				echo "Total amount paid: ";	
				echo "$$totalPrice <br/><br/>";
				
			}
			else 
			{
				echo "System Error: OrderID not found!";
				echo "<br/>";
			}
		}

		else
		{
			echo "System Error: OrderID was not provided!";
			echo "<br/>";
		}

		echo "<form action='empHome.php'>";
			echo "<input type='submit' value='<<Back'>";
		echo "</form>";
		echo "</div>";

		?>
	</div>
	
	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>
	
</body>
</html>

