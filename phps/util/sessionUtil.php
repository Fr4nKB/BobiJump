<?php

	function setSession($username){
		$_SESSION['username'] = $username;
	}

	function isLogged(){		
		if(isset($_SESSION['username']))
			return $_SESSION['username'];
		else
			return false;
	}
	
?>