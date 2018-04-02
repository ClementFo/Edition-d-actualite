<?php

	$connect=mysqli_connect("serveur-win", "root", "admin",$_POST["tablesite"]); // Connexion à MySQL

	if (isset($_POST["submit"]))
	{
		$id=$_POST["actuid"];
		$titre=utf8_decode($_POST["actutitre"]);
		$date=$_POST["actudate"];
		$contenu=utf8_decode($_POST["actucontent"]);

		$sql = "UPDATE actus
				SET titre = '".mysqli_real_escape_string($connect,$titre)."',
					date_miseenligne = '$date',
					contenu = '".mysqli_real_escape_string($connect,$contenu)."'
				WHERE id = '$id' " ;

		// $requete = mysqli_query($connect,$sql) or die( mysqli_error($connect)) ;
		
		$date=date(DateTime::RFC822);
		
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
					$partie[$i]=str_replace($partie[$i], "\r\n".'<title> '.$titre.' </title>'."\r\n".'<description>'."\r\n".'<![CDATA['.$contenu.']]>'."\r\n".'</description>'."\r\n".'<pubDate>'.$date.'</pubDate>'."\r\n".'<guid>http://www.bbs-slama.com/actualites/#a'.$id.'</guid>'."\r\n".'</item>'."\r\n"."\r\n", $partie[$i]); 
				}
			}
		}
		
		$partieRassemble = implode("<item>",$partie);
		print_r($partieRassemble);
	
		$fichierxml = fopen('Actus.xml', 'w+');
		fputs($fichierxml,$partieRassemble);
		fclose($fichierxml);
	
	}

	mysqli_close($connect); // Déconnexion de MySQL
	// header("Location: ".$_SERVER['HTTP_REFERER']);
?>



