<?php
if (!empty($_POST))
{
	include_once("functions_db.php");
	
	try {
		$bdd = new PDO('sqlite:./oeil.sqlite');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if(!empty($_POST)) {
			$pseudo = $_POST['pseudo'];
			$hand = $_POST['hand'];
			$stats_tactile = explode(";", $_POST['stats_tactile']);
			$stats_gestural = explode(";", $_POST['stats_gestural']);
			$game_id = send_stats ($bdd, $pseudo, $hand, $stats_tactile, $stats_gestural);
			echo $game_id;
		}
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>