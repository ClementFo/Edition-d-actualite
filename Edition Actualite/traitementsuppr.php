<?php

	$connect=mysqli_connect("serveur-win", "root", "admin",$_GET["tablesite"]); // Connexion à MySQL

	$id=$_GET["idactu"];

	$sql = "DELETE FROM actus
			WHERE id = '$id' " ;
			
	// $requete = mysqli_query($connect, $sql) or die( mysqli_error($connect)) ;
	
	$file = file_get_contents('Actus.xml');
	$partie = explode("<item>",$file);
	
	for($i=1;$i<count($partie);$i++)
	{			
		if($partie[$i])
		{
			$partiefin = explode("/#a",$partie[$i]);
			
			$secondid=$partiefin[1];
			$secondid=intval($secondid);
			
			if($secondid==$id)
			{
				unset($partie[$i]);
			}
		}
	}
	
	$partieRassemble = implode("<item>",$partie);
	print_r($partieRassemble);
	
	$fichierxml = fopen('Actus.xml', 'a');
	ftruncate($fichierxml, 0);
	fputs($fichierxml,$partieRassemble);
	fclose($fichierxml);

	
	mysqli_close($connect); // Déconnexion de MySQL
	// header("Location: ".$_SERVER['HTTP_REFERER']);
?>