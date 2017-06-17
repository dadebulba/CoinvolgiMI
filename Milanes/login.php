<?php

	$mail = $_POST['mail'];
	$password = $_POST['password'];
	
	$password = md5($password);
	
	$connection = mysqli_connect('localhost', 'hackaton_user', 'hackaton', 'hackaton');
	if ($connection){
		$query = "SELECT * FROM utenti WHERE password='$password' and mail='$mail'";
			
		$risultato = mysqli_query($connection, $query);
			
		mysqli_close($connection);
			
		if ($risultato != null && $risultato->num_rows == 1){
			$row = $risultato->fetch_assoc();
			print_r($row);
			
			
			
		}
		else {
			echo "Non è stato trovato alcun utente con questi parametri. Riprova";
		}
	}
	else {
		echo "C'è stato un errore di connessione al database. Riprova tra poco";
	}

?>