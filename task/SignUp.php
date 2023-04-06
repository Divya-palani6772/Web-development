<?php
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8" /> 
	<title>Elite/Sign-up</title>
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
			<h1>Please sign-up to shop!</h1>
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
			//cookie messages
			echo "<div id=errorCookie>";
			echo "<p>$cookieMessage</p>";
			echo "</div>";
		?>
		
		<form action = 'AddNewCustomer' method = 'POST'>
			
			<fieldset>
				<label for="UserName">Enter your desired username: </label>
				<input type="text" name="UserName" placeholder="nra234"><br><br>

				<label for="FirstName">Enter your First Name: </label>
				<input type="text" name="FirstName" placeholder="Nicholas"><br><br>

				<label for="LastName">Enter your Last Name: </label>
				<input type="text" name="LastName" placeholder="Ramos"><br><br>

				<label for="Address">Enter your Address: </label>
				<input type="text" name="Address" placeholder="8902 Burrows Pass"><br><br>

				<label for="City">Enter your City: </label>
				<input type="text" name="City" placeholder="Jining"><br><br>

				<input type="submit" value="Sign-up">
			</fieldset>
		</form>
	</div>

	<footer class="site-footer">
		<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
	</footer>
	
</body>
</html>