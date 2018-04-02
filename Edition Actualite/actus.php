<?php
	$con=mysqli_connect("serveur-win", "root", "admin",$tablesite); // Connexion à  MySQL
	$actus=mysqli_query($con,'SELECT * FROM actus ORDER BY date_miseenligne DESC');
?>
<script language="javascript">
	function creernew(element)
	{
		if (document.getElementById(element).style.display=='none') document.getElementById(element).style.display='block';
		else document.getElementById(element).style.display='none' ;
	}
	function confirme( identifiant )
	{
		var confirmation = confirm( "Voulez vous vraiment supprimer cet article ?\r\nCette action est irréversible." ) ;
		if( confirmation )
		{
			document.location.href = "../traitementsuppr.php?idactu="+identifiant+"&tablesite=<?php echo $tablesite; ?>" ;
		}
	}
</script>

<div>
<h1>&Eacute;dition des actualités de <?php echo $site; ?></h1>
<p>L'enregistrement d'un article provoque la perte des modifications sur les autres, enregistrez l'article en cours avant d'en créer, modifier ou supprimer un autre.</p>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td width="140px" ><input type="button" class="bouton32Ajouter" onClick="javascript:creernew('actunew');" value="Créer un article"></td>
	</tr>
</table>
<div id="actunew" style="display:none;">
	<form method="post" action="../traitementnew.php">
		<table width="100%">
			<tr>
				<td colspan="2"><input class="actutitre" name="actutitre" type="text" value="<?php echo $news["titre"];?>" size="100%" /></td>
			</tr>
			<tr>
				<td colspan="2"><textarea class="actucontent" rows="12" cols="100%" name="actucontent"><?php echo $news["contenu"];?></textarea></td>
			<tr>
			<tr>
				<td width="140px"><input class="tablesite" name="tablesite" type="hidden" value="<?php echo $tablesite;?>" />
				<input name="submit" class="boutonI24Enregistrer" type="submit" value="Enregistrer l'article" /></td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
</div>
<?php
	$i=0;
	$news=0;
	while($news=mysqli_fetch_array($actus))
	{
?>
<div id="actu<?php echo $i; ?>" style="padding-top:30px;">
	<form method="post" action="../traitementmodif.php">
		<table width="100%">
			<tr>
				<td colspan="3"><input class="actuid" name="actuid" type="hidden" value="<?php echo $news["id"];?>" />
					<input class="actutitre" name="actutitre" type="text" value="<?php echo utf8_encode($news["titre"]);?>" size="100%" /></td>
			</tr>
			<tr>
				<td colspan="3"><input class="actudate" name="actudate" size="100%" type="text" value="<?php echo $news["date_miseenligne"];?>"/></td>
			</tr>
			<tr>
				<td colspan="3"><textarea class="actucontent" rows="10" cols="100%" name="actucontent" id="actucontent<?php echo $i;?>"><?php echo utf8_encode($news["contenu"]);?></textarea></td>
			</tr>
			<tr>
				<td colspan="3"><input class="tablesite" name="tablesite" type="hidden" value="<?php echo $tablesite;?>" /></td>
			</tr>
			<tr>
				<td width="140px"><input class="boutonI24Supprimer" title="Supprimer l'article" type="button" onClick="javascript:confirme('<?php echo $news["id"];?>');" value="Supprimer l'article"></td>
				<td width="140px" align="left"><input name="submit" title="Enregistrer les modifications de l'article" class="boutonI24Enregistrer" type="submit" value="Enregistrer l'article" /></td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
</div>
<?php
		$i+=1;
	}
	mysqli_free_result($actus);
	mysqli_close($con); // Déconnexion de MySQL
?>
