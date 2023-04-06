<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/Products</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>

<body>

	<div class ="page-wrap">

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
				<h1>Products List</h1>
			</div>

			<div id = "navbar">
		        <ul>
		          <li><a href="empHome.php">Home</a></li>
		          <li><a href="CustomerList.php">Customers List</a></li>
		          <li><a href="OrderList.php">Orders List</a></li>
		          <li><a href="productTable.php">Products List</a></li>     
		          <li><a href="index.php">Log Out</a></li>     
		        </ul>
		  </div>
		  <br>

		    <?php 

					// include some functions from another file.
					include('functions.php');

					//DATABASE CONNECTION
					// connect to the database using our function (and enable errors, etc)
					$dbh = connectToDatabase();

					$statement = $dbh->prepare('SELECT op.ProductID, p.Description, p.Price, b.BrandName, COUNT (DISTINCT op.OrderID														) AS Popularity, SUM(op.Quantity) AS TotalQuantity, SUM(p.Price * op.Quantity) AS TotalRevenue
																			FROM OrderProducts op
																			INNER JOIN Products p ON op.ProductID=p.ProductID
																			INNER JOIN Brands b ON p.brandID=b.brandID
																			GROUP BY p.ProductID
																			ORDER BY TotalRevenue DESC;
																			;');

					//execute the SQL.
					$statement->execute();

					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						// Remember that the data in the database could be untrusted data. 
						// so we need to escape the data to make sure its free of evil XSS code.
						$ProductID = makeOutputSafe($row['ProductID']);
						$Description = makeOutputSafe($row['Description']);
						$Price = makeOutputSafe($row['Price']);
						$BrandName = makeOutputSafe($row['BrandName']);
						$Popularity = makeOutputSafe($row['Popularity']);
						$TotalQuantity = makeOutputSafe($row['TotalQuantity']);
						$TotalRevenue = makeOutputSafe($row['TotalRevenue']);


						//Display the details in a table
						echo "<br/>";
						echo "<div class = 'productBox'>";
							echo "<div id= table>";
								echo "<table>";
								echo "<tr><th> <a href='ViewProduct2.php?ProductID=$ProductID'> Product ID </a> </th><td> $ProductID </td></tr>";
								echo "<tr><th> Description </th><td> $Description </td></tr>";
								echo "<tr><th> Price </th><td> $$Price </td></tr>";
								echo "<tr><th> Brand Name </th><td> $BrandName </td></tr>";
								echo "<tr><th> No.Of Orders placed </th><td> $Popularity </td></tr>";
								echo "<tr><th> Total Quantity </th><td> $TotalQuantity </td></tr>";
								echo "<tr><th> Total Revenue </th><td> $$TotalRevenue </td></tr>";
								echo "</table>";
							echo "</div>";
						echo "</div>";

					}

			?>
	</div>

	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>

</body>
</html>



















