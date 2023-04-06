<?php 
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" /> 
		<title>Elite/Home Page</title>
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
				<h1>Welcome to Elite Shopping site!!</h1>
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
		    <br><br>

			<?php
			// displaying cookie messages. 
			echo "<div id=cookie>";
			echo "<br/><br/><p>$cookieMessage</p>";
			echo "</div><br/>";
			?>

			<div id = "alignment">
				<form method="GET" action="ProductList.php">
					<input name = 'search' type = 'text' value = '' placeholder="Search Products here" />
					<input type = 'submit'/>
					&nbsp;
					&nbsp;
					&nbsp;
				</form><br>
				<p>Biggest sale going on for festive season. Why wait? Hurry Up and grab the offers.</p>
				<p>Free delivery for all products!</p>
				<p>Have a great shopping!!!</p>
				<br>
				<img src='../IFU_Assets/discountSale.jpeg' alt ='' /> &ensp;
			
			</div>

					<div id="cssSlider">
					<div id="sliderImages">
						<img src="../IFU_Assets/ProductPictures/0010942122661.jpg" alt="" />
						<img src="../IFU_Assets/ProductPictures/0011009525647.jpg" alt="" />
						<img src="../IFU_Assets/ProductPictures/0011120031690.jpg" alt="" />
						<img src="../IFU_Assets/ProductPictures/0011120015430.jpg" alt="" />
						<img src="../IFU_Assets/ProductPictures/0012748751908.jpg" alt="" />
					</div>
					</div>

		</div>	

		<footer class="site-footer">
			<h5>&copy 2002-2021, Elite.com, Inc. or its affiliates</h5>
		</footer>			

	</body>
</html>