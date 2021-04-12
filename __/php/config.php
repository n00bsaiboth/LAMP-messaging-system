<?php
    $host = 'localhost';
	$db   = 'temporary_messaging_system';
	$user = 'root';
	$pass = 'mysql';

    try {
	    $dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
	} catch (PDOException $e) {
	    die("Error: " . $e->getMessage());
    }

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dbh->exec("SET NAMES utf8");
	
	/* functions
	 *
	 */

    // the arguments needs to be null, or else we get an error

	function getProfileDetails($dbh = null, $id = null) {
		$query = "SELECT * FROM `users` WHERE `id`=:id";

		$stmt = $dbh->prepare($query);
	
		$stmt->bindParam('id', $id, PDO::PARAM_STR);
	
		$stmt->execute();
		
		$count = $stmt->rowCount();
		$row   = $stmt->fetch(PDO::FETCH_ASSOC);

		if($count == 1 && !empty($row)) {
			return $row;
		}
	}

	// check if username exists

	function checkIfUserExists($dbh = null, $username = null) {

		$query = "SELECT * FROM `users` WHERE `username`=:username";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('username', $username, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
        	$_SESSION["error"] = "Unfortunately, it looks like the username has already been taken. ";
        
        	header("Location: error.php");
    	} 
	}


	function checkIfUserWithAnIDExists($dbh = null, $id = null) {

		$query = "SELECT * FROM `users` WHERE `id`=:id";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('id', $id, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
        	$_SESSION["error"] = "We found the user with the corresponding ID-number. ";
        
        	header("Location: error.php");
    	} 

	}

	/* Check if User with and ID and Password exists.
	 *
	 * 

	function checkIfUserWithAnIDAndPasswordExists($dbh = null, $id = null) {

		$query = "SELECT * FROM `users` WHERE `id`=:id";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('id', $id, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
			if($_POST["currentpassword"] == $row["password"]) {
				$_SESSION["error"] = "Unfortunately, you entered the wrong password. ";
			} else {

				header("Location: error.php");
			}
        	
        
        	
    	} 

	}

	*/

	// add new user

	function addNewUser($dbh = null, $username = null, $password = null) {


		$sql = "INSERT users (username, password) VALUES (:username, :password)";

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":username", $username, PDO::PARAM_STR);
		$stmt->bindParam(":password", $password, PDO::PARAM_STR);
	
		if($stmt->execute()) {
			header("location: index.php");
		} 
	}

	// remove user

	function removeUser($dbh = null, $id = null) {


		$sql = "DELETE FROM `users` WHERE id = :id";

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);	

		if($stmt->execute()) {
			$_SESSION['id'] = "";

			header("location: index.php");			
		} else {
			$_SESSION["error"] = "Unfortunately, there was some error while removing your user account. We think that the error was, that there was no corresponding ID-number, with your user account. ";
	
			header("Location: error.php");
		}
	}

	// update user password

	function updateUserPassword($dbh = null, $password = null, $id = null) {
		$sql = "UPDATE users SET password = :password WHERE id = :id";

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":password", $password, PDO::PARAM_STR);
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);	

		if($stmt->execute()) {

			header("location: index.php");			
		} else {
			$_SESSION["error"] = "Unfortunately, something went wrong. ";
	
			header("Location: error.php");
		}

	}

	// login

	function login($dbh = null, $username = null, $password = null) {

		// Searching the username from the database

		$query = "SELECT * FROM `users` WHERE `username`=:username";

		$stmt = $dbh->prepare($query);
	
		$stmt->bindParam('username', $username, PDO::PARAM_STR);
	
		$stmt->execute();
	
		$count = $stmt->rowCount();
		$row   = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if($count == 1 && !empty($row)) {
			// $message = "Username was found on the database. <br />";     
			if (password_verify($password, $row["password"])) {
				// $message2 = "Password is valid. <br />";
	
				// Quite not sure if this works, but try to make the $session_id variable to be integer.    
	
				$_SESSION["id"] = filter_var($row["id"], FILTER_VALIDATE_INT);
				$_SESSION["username"] = filter_var($row["username"], FILTER_SANITIZE_STRING);
	
				header('location:index.php');
			} else {
				$_SESSION["error"] = "Unfortunately, it looks like you have the wrong password. ";
	
				header("Location: error.php");
			}
		} else {
			$_SESSION["error"] = "Unfortunately, it looks like we can't find the username from our database. ";
	
			header("Location: error.php");
			// echo "username or password invalid.";
		}
	}

	// get the ID number of an user

	function getIDnumberOfExistingUser($dbh = null, $username = null) {

		$query = "SELECT * FROM `users` WHERE `username`=:username";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('username', $username, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
        	return $row["id"];
    	} else {
			$_SESSION["error"] = "Unfortunately, there are no such user with the given ID-number. ";
	
			header("Location: error.php");			
		}
	}

	function getUsernameIfExists($dbh = null, $username = null) {

		$query = "SELECT * FROM `users` WHERE `username`=:username";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('username', $username, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
        	$_SESSION["error"] = "Unfortunately, it looks like the username has already been taken. ";
        
        	header("Location: error.php");
    	} 
	}

	function getUsernameByID($dbh = null, $id = null) {

		$query = "SELECT * FROM `users` WHERE `id`=:id";

		$stmt = $dbh->prepare($query);

    	$stmt->bindParam('id', $id, PDO::PARAM_STR);

    	$stmt->execute();

    	$count = $stmt->rowCount();
    	$row   = $stmt->fetch(PDO::FETCH_ASSOC);

    	if($count == 1 && !empty($row)) {
        	return $row["username"];
    	} 
	}

	// send message

	function sendNewMessage($dbh = null, $recipient_id = null, $sender_id = null, $header = null, $message = null) {
		$sql = "INSERT messages (recipient_id, sender_id, header, message) VALUES (:recipient_id, :sender_id, :header, :message)";

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":recipient_id", $recipient_id, PDO::PARAM_INT);
		$stmt->bindParam(":sender_id", $sender_id, PDO::PARAM_INT);
		$stmt->bindParam(":header", $header, PDO::PARAM_STR);
		$stmt->bindParam(":message", $message, PDO::PARAM_STR);
	
		if($stmt->execute()) {
			header("location: index.php");
		} 
	}

	// get messages 

	function getNewMessages($dbh = null, $id = null) {

		$sql = "SELECT * FROM `messages` WHERE `recipient_id` = :id";

		$stmt = $dbh->prepare($sql);

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt->execute()) {
			while($row = $stmt->fetch()) {
				echo "<p><a href=\"singlemessage.php?id={$row["id"]}\">" .  $row["header"] . "</a></p>";
				
			}
		} else {

		}
	}

	// get single message

	function getSingleMessage($dbh = null, $id = null) {
		$sql = "SELECT * FROM `messages` WHERE `id` = :id";

		$stmt = $dbh->prepare($sql);

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);	
		
		$stmt->execute();
		
		$count = $stmt->rowCount();
		$row   = $stmt->fetch(PDO::FETCH_ASSOC);

		if($count == 1 && !empty($row)) {
			return $row;
		}
	}

	// remove single message

	function removeSingleMessage($dbh = null, $id = null) {

		$sql = "DELETE FROM `messages` WHERE `id` = :id";

		$stmt = $dbh->prepare($sql);
	
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt->execute()) {
			header("location: messages.php");    
		  }
	}
?>