<?php
    require_once "BobiJumpDBManager.php";
	//funzione per inserire un nuovo utente nel db
 	function insertNew ($username, $email, $password) {
		global $BobiJumpDB;
		$user = $BobiJumpDB->sqlInjectionFilter($username);
		$mail = $BobiJumpDB->sqlInjectionFilter($email);
		$pwd = $BobiJumpDB->sqlInjectionFilter($password);
		$query = 'INSERT INTO `user` VALUES(\'' . $user . '\', \'' . $mail . '\', \'' . $pwd . '\', 0, DEFAULT)';
		$BobiJumpDB->performQuery($query);
		$query = 'INSERT INTO unlocked VALUES(\'' . $user . '\', 1, 0)';
		$BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
	}
	
	//funzione che dati username e email controlla se esiste un utente che già utilizza questi dati
	function alreadyExists($username, $email){
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$email = $BobiJumpDB->sqlInjectionFilter($email);
		$query = 'SELECT 1 FROM user WHERE username = \'' . $username . '\' OR email = \'' . $email . '\' LIMIT 1';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		return $result;
	}
	
	//funzione che sblocca un personaggio
	function unlock($username, $characterId) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$characterId = $BobiJumpDB->sqlInjectionFilter($characterId);
		$query = 'INSERT INTO unlocked VALUES (\'' . $username . '\', (SELECT characterId FROM `characters` WHERE name = \'' . $characterId . '\'), 0)';
		$result = $BobiJumpDB->affectedRows($query);
		$BobiJumpDB->closeConnection();
		return $result;
	}

	//funzione che in resistuisce una stringa quando si sblocca un personaggio
	function skinUL($score){
		global $BobiJumpDB;
		$score = $BobiJumpDB->sqlInjectionFilter($score);
		if ($score >= 50000) {
			if(unlock($_SESSION['username'], 'clown')==1)
				echo json_encode(['result'=>'Clown sbloccato']);
		} 
		else if ($score >= 75000) {
			echo json_encode(['result'=>'Trump sbloccato']);
		}
		else echo json_encode(['result'=>'']);
	}

	//funzione che aggiorna il campo highscore nel db
	function newhighscore($username, $score){
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$score = $BobiJumpDB->sqlInjectionFilter($score);
		$query = 'UPDATE user U INNER JOIN (SELECT username FROM user WHERE highscore <= \'' . $score . '\' AND username = \'' . $username . '\') F ON U.username = F.username
			SET highscore = \'' . $score . '\' WHERE U.username = \'' . $username . '\'';
		$BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		skinUL($score);
	}

	//funzione che restituisce tutte e sole le skin sbloccate dall'utente
	function charList($username) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$query = 'SELECT C.* FROM characters C NATURAL JOIN unlocked UL NATURAL JOIN user U WHERE U.username = \'' . $username . '\'';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		return $result;
	}

	//funzione che restituisce nome, path e tempo di utilizzo della skin più usata
	function mostUsed($username) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$query = 'SELECT C.name, C.path, SEC_TO_TIME(U.time) FROM unlocked U NATURAL JOIN characters C WHERE username = \'' . $username . '\' ORDER BY `time` DESC LIMIT 1';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		return $result;
	}

	//funzione che preleva la skin corrente e il path dove si trova
	function fetchSkin($username) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$query = 'SELECT U.currentSkin, C.path FROM `user` U INNER JOIN (SELECT characterId, `path` FROM `characters`) C ON C.characterId = U.currentSkin WHERE username = \'' . $username . '\'';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		$row = mysqli_fetch_row($result);
		return $row;
	}

	//funzione che aggiorna la skin corrente nel db
	function updateSkin($username, $newSkin) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$query = 'UPDATE `user` SET `currentSkin` = ' . $newSkin . ' WHERE username = \'' . $username . '\'';
		$BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
	}

	//funzione che aggiorna il tempo passato a giocare con la skin corrente
	function updateTime($username, $time) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$time = $BobiJumpDB->sqlInjectionFilter($time);
		$query = 'UPDATE `unlocked` U INNER JOIN (SELECT `username`, `currentSkin` FROM `user` WHERE username = \'' . $username . '\') S ON S.currentSkin = U.characterId AND S.username = U.username
			SET `time` = time+' . $time . ' WHERE U.username = \'' . $username . '\'';	
		$BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
	}

	//funzione che si occupa di restituire tutti i dati relativi alla scoreboard e di ordinare il result set
	function fetchScoreboard() {
		global $BobiJumpDB;
		$query = 'SELECT username, characterId, highscore, SEC_TO_TIME(totale)
				FROM
				(SELECT R.username, M.characterId, R.highscore, M.totale
					FROM `user` R INNER JOIN 
						(SELECT *
							FROM
							(SELECT U.username, characterId, tmp.totale, U.time
								FROM unlocked U	INNER JOIN 
								(SELECT username, SUM(`time`) AS totale
									FROM unlocked
								GROUP BY username) TMP ON U.username = TMP.username
							ORDER BY `time` DESC) T
            			GROUP BY username) M ON M.username = R.username
	  			ORDER BY highscore DESC) Y';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		return $result;
	}

	//funzione per prelevare la velocità del personaggio utilizzato dal db
	function fetchvel($username) {
		global $BobiJumpDB;
		$username = $BobiJumpDB->sqlInjectionFilter($username);
		$query = 'SELECT `velocity` FROM characters C INNER JOIN (SELECT `currentSkin` FROM `user` WHERE `username` = \'' . $username . '\') U ON U.currentSkin = C.characterId';
		$result = $BobiJumpDB->performQuery($query);
		$BobiJumpDB->closeConnection();
		$row = mysqli_fetch_row($result);
		return intval($row[0]);
	}
	
?>