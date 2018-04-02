<?php
	$connect=mysqli_connect("serveur-win", "root", "admin",$_POST["tablesite"]); // Connexion à MySQL
	
	if (isset($_POST["submit"]))
	{
		$titre=utf8_decode($_POST["actutitre"]);
		$contenu=utf8_decode($_POST["actucontent"]);
		
		$sql = "INSERT  INTO actus(titre, date_miseenligne, contenu)
				VALUES ('".mysqli_real_escape_string($connect,$titre)."', now(), '".mysqli_real_escape_string ($connect,$contenu)."')" ;
				
		// $requete = mysqli_query($connect, $sql) or die( mysqli_error($connect)) ;
		
		
		$date=date(DateTime::RFC822);
		
		$id=mysqli_insert_id($connect);
		
		$handle = file_get_contents('Actus.xml');
		$debutfichier = strstr($handle,'<item>',true);
		$tailledebutcode = strlen($debutfichier);
		
		$contenuActus = file_get_contents('Actus.xml', NULL, NULL,$tailledebutcode);
		
		$fichierxml = fopen('Actus.xml', 'a');
		ftruncate($fichierxml, $tailledebutcode);
		fputs($fichierxml,"\r\n".'<item>'."\r\n".'<title> '.$titre.' </title>'."\r\n".'<description>'."\r\n".'<![CDATA['.$contenu.']]>'."\r\n".'</description>'."\r\n".'<pubDate>'.$date.'</pubDate>'."\r\n".'<guid>http://www.bbs-slama.com/actualites/#a'.$id.'</guid>'."\r\n".'</item>'."\r\n");
		fputs($fichierxml,"\r\n".$contenuActus);
		fclose($fichierxml);	
	}	
		
	mysqli_close($connect); // Déconnexion de MySQL
	//header("Location: ".$_SERVER['HTTP_REFERER']);
?>