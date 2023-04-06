<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/Customer list</title>
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
			<h1>List of all the customers!</h1>
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

			// include some functions from another file.
			include('functions.php');
			//FOR SEARCHING PRODUCTS
	
			// if the user provided a search string.
			if(isset($_GET['search']))
			{
		 		$searchString = $_GET['search'];
			}

			else if(isset($_POST['search']))
			{
		 		$searchString = $_POST['search'];
			}

			// if the user did NOT provided a search string, assume an empty string
			else 
			{
		 		$searchString = "";
			}

			$safeSearchString = htmlspecialchars($searchString, ENT_QUOTES,"UTF-8");
			$SqlSearchString = "%$searchString%";

			echo "<div id = 'alignment'>";
			echo "<form>";
			echo "<p>Enter a customer ID to search:</p><br/>";
			echo "<input name = 'search' type = 'text' value = '$safeSearchString' />";
			echo "<input type = 'submit' value = 'search'/>";
			echo "</form>";


			//FOR SEARCHING PAGES

			if(isset($_GET['page']))
			{
	 			$currentPage = intval($_GET['page']);
			}
			else
			{
	 			$currentPage = 0;
	 		}

	 		echo "<br/><form>";
	 		echo "<p>Enter page number:</p><br/>";
			echo "<input name = 'page' type = 'text' value = '$currentPage'/>";
			echo "<input type = 'submit' value = 'search'/>";
			echo "</form>";

			$nextPage = $currentPage + 1;

			echo "<br/><a href = 'CustomerList.php?page=$nextPage&search=$safeSearchString'>Next Page-></a>";
			echo "</div>";

			$previousPage = $currentPage - 1;
			if ($currentPage>0)
			{
				echo "<a href = 'CustomerList.php?page=$previousPage&search=$safeSearchString'><div id='alignment'><-Previous Page</div></a>";
				echo "<br/>";
			}

			//DATABASE CONNECTION

			// connect to the database using our function (and enable errors, etc)
			$dbh = connectToDatabase();

			$statement = $dbh->prepare('SELECT * FROM Customers
										WHERE CustomerID LIKE ?
										LIMIT 10
										OFFSET ? * 10
										;');

			$statement->bindValue(1,$SqlSearchString);
			$statement->bindValue(2,$currentPage);


			//execute the SQL.
			$statement->execute();

			// get the results
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				// Remember that the data in the database could be untrusted data. 
				// so we need to escape the data to make sure its free of evil XSS code.
				$CustomerID = makeOutputSafe($row['CustomerID']);
				$UserName = makeOutputSafe($row['UserName']);
				$FirstName = makeOutputSafe($row['FirstName']);
				$LastName = makeOutputSafe($row['LastName']);
				$Address = makeOutputSafe($row['Address']);
				$City = makeOutputSafe($row['City']);


				//Display the details in a table
				echo "<br/>";
				echo "<div class = productBox>";
				echo "<div id= table>";
				echo "<table>";
				echo "<tr><th> CustomerID </th><td> $CustomerID</td></tr>";
				echo "<tr><th> User Name </th><td> $UserName </td></tr>";
				echo "<tr><th> First Name </th><td>$FirstName</td></tr>";
				echo "<tr><th> Last Name </th><td> $LastName </td></tr>";
				echo "<tr><th> Address </th><td> $Address </td></tr>";
				echo "<tr><th> City </th><td> $City </td></tr>";
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



















