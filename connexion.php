<?php
$db_server = "localhost";
 	$db_usr = "Abdul";
 	$db_psw = "facesimplon";
 	$db_name = "app_compta";

	 try{
		$connexion = new PDO("mysql:host=$db_server;dbname=$db_name",$db_usr,$db_psw);
		$connexion ->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		echo 'Connexion à la base de donnée réussie!';
	}
	catch (Exception $e){
		echo 'Echec de la connection : '.$e->getMessage();

	} 
	