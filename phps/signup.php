<?php
    require_once "./util/sessionUtil.php";
    require_once "./util/BobiJumpDB.php";
	
    $username = $_POST['username'];
    $email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	signUp($username, $email, $password);   

	function signUp($username, $email, $password){
        $errorMessage = 'I dati inseriti non sono validi.'; //messaggio di errore di default
		if ($username != null && $password != null && $email != null){
            $var = (mysqli_num_rows(alreadyExists($username, $email))==0);  //se i dati inseriti non sono già presenti procedo con la registrazione
            if ($var) {
                insertNew($username, $email, $password);
                $errorMessage = 'Registrazione effettuata con successo.';
                echo "<script> alert('$errorMessage'); window.location = \"./loginpage.php\"; </script>";   //se tutto è andato bene vado alla pagina di login
            }
            else $errorMessage = 'Username non disponibile o email gia` in utilizzo.';
            
        }
        
    	echo "<script> alert('$errorMessage'); window.location = \"./signuppage.php\"; </script>";
	}
?>