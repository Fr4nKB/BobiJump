<?php
    require_once "./util/BobiJumpDBManager.php";
	require_once "./util/sessionUtil.php";
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$errorMessage = login($username, $password);
	if($errorMessage === null)
		header('location: ./index.php');
	else {
		echo "<script> alert('$errorMessage'); window.location = \"./loginpage.php\"; </script>";
	}
		
	function login($username, $password){
		if ($username != null && $password != null) {

			if (authenticate($username, $password)) {
    			session_start();
				setSession($username, $userId);
    			return null;
    		}
			
			else
    			return 'I dati inseriti non sono corretti.';

    	} 
    	
    	return 'Username e password non validi.';
	}
	
	function authenticate($username, $password){   
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$password = $BobiJumpDB->sqlInjectionFilter($password);

		$query = "SELECT `password` FROM user WHERE username = '" . $username . "'";

		$result = $BobiJumpDB->performQuery($query);
		$result = mysqli_fetch_row($result);

		if (password_verify($password, $result[0]))
			return 1;
		else return 0;
	}

?>