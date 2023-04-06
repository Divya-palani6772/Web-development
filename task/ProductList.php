<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/Products Page</title>
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
			<h1>Products</h1>
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
	    <br>

	    <div id='alignment'>
			 <form method= 'GET'>
				<label for='me'>Sort Products by:</label>
				<select id='me' name='me'>
				<option value=''>--Choose--</option>
				<option value='popularity'>popularity</option>
		  	<option value='AtoZ'>Name: A to Z</option>
		  	<option value='ZtoA'>Name: Z to A</option>
		  	<option value='LtoH'>Price: Low to High</option>
		  	<option value='HtoL'>Price: High to Low</option>
				</select>
				<button type='submit'>search</button>
			 </form><br>
			</div>
		
	
		<?php 

			// includes some functions from another file.
			include('functions.php');	

			//FOR SEARCHING PRODUCTS
			// if the user provided a search string.
			if(isset($_GET['search']))
			{
		 		$searchString = $_GET['search'];
		 		$value = 'popularity';
			}

			else if(isset($_POST['search']))
			{
		 		$searchString = $_POST['search'];
		 		$value = 'popularity';
			}

			// if the user did NOT provided a search string, assume an empty string
			else 
			{
		 		$searchString = "";
		 		$value = 'popularity';
			}

			$safeSearchString = htmlspecialchars($searchString, ENT_QUOTES,"UTF-8");
			$SqlSearchString = "%$searchString%";

			echo "<div id = 'alignment'>";
			echo "<form>";
			echo "<p>Enter a product name to search:</p><br/>";
			echo "<input name = 'search' type = 'text' value = '$safeSearchString' />";
			echo "<input type = 'submit' value = 'search'/>";
			echo "</form>";

			//FOR SEARCHING PAGES
			if(isset($_GET['page']))
			{
	 			$currentPage = intval($_GET['page']);
	 			$value = 'popularity';
			}
			else
			{
	 			$currentPage = 0;
	 			$value = 'popularity';
	 		}

	 		echo "<br/><form>";
	 		echo "<p>Enter page number:</p><br/>";
			echo "<input name = 'page' type = 'text' value = '$currentPage'/>";
			echo "<input type = 'submit' value = 'search'/>";
			echo "</form>";

			$nextPage = $currentPage + 1;

			echo "<br/><a href = 'ProductList.php?page=$nextPage&search=$safeSearchString'>Next Page-></a>";
			echo "</div>";

			$previousPage = $currentPage - 1;

			if ($currentPage>0)
			{
				echo "<a href = 'ProductList.php?page=$previousPage&search=$safeSearchString'><div id='alignment'><-Previous Page</div></a>";
				echo "<br/>";
			}

			if (isset($_GET['me']))
			{
				$value = $_GET['me'];
			}

			//DATABASE CONNECTION
			// connect to the database using our function (and enable errors, etc)
			$dbh = connectToDatabase();
			
				// select all the products based on No.of orders i.e.,popularity

					if($value == 'AtoZ')
					{
						$statement = $dbh->prepare('SELECT * FROM Products 
						WHERE Description LIKE ?
						ORDER BY Description
						LIMIT 10 
						OFFSET ? * 10
						;'); 		
					} 

					elseif($value == 'ZtoA')
					{
						$statement = $dbh->prepare('SELECT * FROM Products 
						WHERE Description LIKE ?
						ORDER BY Description DESC
						LIMIT 10 
						OFFSET ? * 10
						;'); 
					}

					elseif($value == 'LtoH')
					{
						$statement = $dbh->prepare('SELECT * FROM Products 
						WHERE Description LIKE ?
						ORDER BY Price
						LIMIT 10 
						OFFSET ? * 10
						;');
					}

					elseif($value == 'HtoL')
					{
						$statement = $dbh->prepare('SELECT * FROM Products 
						WHERE Description LIKE ?
						ORDER BY Price DESC
						LIMIT 10 
						OFFSET ? * 10
						;');
					}

					else
					{
						$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
						ON OrderProducts.ProductID = Products.ProductID
						WHERE Products.Description LIKE ? 
						GROUP BY Products.ProductID 
						ORDER BY COUNT(OrderProducts.OrderID) DESC
						LIMIT 10 
						OFFSET ? * 10
						;'); 			
					}

					$statement->bindValue(1,$SqlSearchString);
					$statement->bindValue(2,$currentPage);

					//execute the SQL.
					$statement->execute();
			
					// get the results
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						// Remember that the data in the database could be untrusted data. 
						// so we need to escape the data to make sure its free of evil XSS code.
						$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8'); 
						$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
						$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
						
						// output the data in a div with a class of 'productBox' we can apply css to this class.
						echo "<div class = 'productBox'>";
						echo "<a href='../Lab07/ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' /></a>  ";
						echo "$Description <br/>";
						echo "$$Price <br/>";
						echo "</div> \n";			
					}
		
			?>
	</div>

	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>
</body>
</html>