<?php




	// get information about logged in user if available, false if not logged in

	function name() {
		return @$_SESSION['Username'];
	}

	function usertype() {
		return @$_SESSION['User_type'];
	}

	// basic authentication functions
	function logout() {
		session_destroy();
	}

	//filters any fishy input
	function sqli_filter($string) {
		$filtered_string = $string;
		$filtered_string = str_replace("--","",$filtered_string);
		$filtered_string = str_replace(";","",$filtered_string);
		$filtered_string = str_replace("/*","",$filtered_string);
		$filtered_string = str_replace("*/","",$filtered_string);
		$filtered_string = str_replace("//","",$filtered_string);
		$filtered_string = str_replace(" ","",$filtered_string);
		$filtered_string = str_replace("#","",$filtered_string);
		$filtered_string = str_replace("||","",$filtered_string);
		$filtered_string = str_replace("admin'","",$filtered_string);
		$filtered_string = str_replace("UNION","",$filtered_string);
		$filtered_string = str_replace("COLLATE","",$filtered_string);
		$filtered_string = str_replace("DROP","",$filtered_string);
		return $filtered_string;
	}
	function login($username, $password, $link) {
		$escaped_username = sqli_filter($username);
		$sql = "SELECT * FROM USER WHERE Username='$escaped_username'";
		$result = mysqli_query($link, $sql);
		$user = mysqli_fetch_row($result);
		// make sure the user exists
		if (!$user) {
			notify('User does not exist', -1);
			return false;
		}
		// verify the password hash

		$hash = sha1($password);
		$sql = "SELECT Username, User_type FROM USER WHERE Username='$username' AND Password='$hash'";
		$result = mysqli_query($link, $sql);
		$userdata =mysqli_fetch_row($result);
		if ($userdata) {
			// awesome, we're logged in
			$_SESSION['Username'] = $userdata[0] ;
			$_SESSION['User_type'] = $userdata[1];
		} else {
			notify('Invalid password', -1);
			return false;
		}
	}
	function register($username, $email, $password1, $password2, $usertype, $link) {
		$escaped_username = sqli_filter($username);
		// make sure the user doesn't exist
		$sql = "SELECT Username FROM USER WHERE Username='$escaped_username'";
		$result = mysqli_query ($link, $sql);
		if (mysqli_fetch_row($result)) {
			notify('User exists!', -1);
			return false;
		}
		// make sure the passwords match
		if ($password1 != $password2) {
			notify('Passwords do not match', -1);
			return false;
		}
		// OK good to go! insert the user
		$hash = sha1($password1);
		$sql = "INSERT INTO USER (Email, Username, Password, User_type) VALUES ".
			"('$email', '$escaped_username', '$hash', '$usertype')";
		mysqli_query ($link, $sql);
		// redirect to homepage
		notify('Account '.$username.' registered. Please log in');
		return true;
	}

?>
