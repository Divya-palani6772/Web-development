<?php 

	// this php file will have no HTML

	include('functions.php');

	if(!isset($_POST['UserName']))
	{
		echo "UserName not provided, make sure your form is using POST"; 
	}
	elseif(!isset($_POST['FirstName']))
	{
		echo "FirstName not provided"; 
	}
	elseif(!isset($_POST['LastName']))
	{
		echo "LastName not provided"; 
	}
	elseif(!isset($_POST['Address']))
	{
		echo "Address not provided"; 
	}
	elseif(!isset($_POST['City']))
	{
		echo "City not provided"; 
	}
	else
	{
		$dbh = connectToDatabase();
		
		$UserName = trim($_POST['UserName']);
		$FirstName = trim($_POST['FirstName']);
		$LastName = trim($_POST['LastName']);
		$Address = trim($_POST['Address']);
		$City = trim($_POST['City']);

		// lets check to see if the user name is taken, COLLATE NOCASE tells SQLite to do a case insensitive match.
		$statement = $dbh->prepare('SELECT * FROM Customers WHERE UserName = ? COLLATE NOCASE; ');
		$statement->bindValue(1,  $UserName  );
		$statement->execute();
			
		// we found a match, so inform the user that they cant use the user-name.
		if($row2 = $statement->fetch(PDO::FETCH_ASSOC))
		{
			//set error cookie
			setCookieMessage("The UserName '$UserName' is Taken by someone else! Please try again.");
			redirect("SignUp.php");
		}
		else
		{		
			// add the new customer to the customers table.
			$statement2 = $dbh->prepare('INSERT INTO Customers(UserName,FirstName,LastName,Address,City)
										 VALUES (?,?,?,?,?);');
			
			$statement2->bindValue(1, $UserName );
			$statement2->bindValue(2, $FirstName );
			$statement2->bindValue(3, $LastName );
			$statement2->bindValue(4, $Address );
			$statement2->bindValue(5, $City );
			
			//execute the query
			$statement2->execute();
			
			//set success cookie
			setCookieMessage("Welcome $FirstName!, you can now buy some products!");
			redirect("Homepage.php");		
		}
}
