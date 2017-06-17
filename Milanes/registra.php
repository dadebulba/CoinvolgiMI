<?php
	
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$mail = $_POST['mail'];
	$via = $_POST['via'];
	$cf = $_POST['cf'];
	$password = $_POST['password'];
	
	$password = md5($password);
	
	echo "<html><body>";
	
	//Aggancio alla via le informazioni di Milano
	$via = $via.",Milano,Italia";
	
	//Ricavo latitudine e longitudine con geocode
	// url encode the address
    $address = urlencode($via);
     
    // google map geocode api url
    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyBLfPHCRRYVq23cZ9y3OaMjsxBgIt-qOYk";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];
         
        //Faccio l'insert nel database
		$connection = mysqli_connect('localhost', 'hackaton_user', 'hackaton', 'hackaton');
		if ($connection){
			$query = "INSERT INTO utenti(nome,cognome,mail,via,codiceFiscale,password,latitudine,longitudine) VALUES('$nome','$cognome','$mail','$formatted_address','$cf','$password','$lati','$longi')";
			
			mysqli_query($connection, $query);
			
			mysqli_close($connection);
		}
		else {
			echo "Non connesso al database";
		}
		
		header("location: login.html");
    }
	else {
		echo "Il sito di geolocalizzazione ha riscontrato un errore. Riprova ad inserire l'indirizzo di residenza";
	}
	
	echo "</body></html>";

?>