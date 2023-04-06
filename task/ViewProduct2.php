<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/View Product</title>
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
			<h1>Showing the selected product..</h1>
		</div>

		<div id = "navbar">
	        <ul>
	          <li><a href="Homepage.php">Home</a></li>
			      <li><a href="CustomerList.php">Customers List</a></li>
			      <li><a href="OrderList.php">Orders List</a></li>
			      <li><a href="productTable.php">Products List</a></li>
			      <li><a href="index.php">Log Out</a></li>
	        </ul>
	    </div>

		<?php 
			
			// include some functions from another file.
			include('functions.php');
			
			if(isset($_GET['ProductID']))
			{		
				$productIDURL = $_GET['ProductID'];

				// connect to the database using our function (and enable errors, etc)
				$dbh = connectToDatabase();
				
				//select statement
				$statement = $dbh->prepare('SELECT * FROM Products INNER JOIN Brands ON Brands.BrandID = Products.BrandID
					WHERE Products.ProductID = ?' );

				//bindValue
				$statement->bindValue(1, $productIDURL);
				
				//execute the SQL.
				$statement->execute();

				// get the result, there will only ever be one product with a given ID (because products ids must be unique)
				// so we can just use an if() rather than a while()
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
					echo "<img src = '../IFU_Assets/ProductPictures/$productIDURL.jpg' alt= 'productID' /> <br/>";
					echo "<a href='https://www.$BrandName.com.au'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID' /></a><br/>";
					
					echo "<form action='productTable.php'>";
					echo "<button name='page' type='submit'>Back to Products Table</button><br/><br/>";
					echo "</form>";
					echo "</div>";
					

				}

				else
				{
					echo "Unknown Product ID";
				}
			}

			else
			{
				echo "No ProductID provided!";
			}
			
		?>
	</div>

	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>

</body>
</html>