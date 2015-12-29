<?php
if (!empty($_POST))
{
	try {
		$db_handle = new PDO('sqlite:oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$pseudo = $_POST['pseudo'];
		$hand = $_POST['hand'];
		$stats_tactile = explode(";", $_POST['stats_tactile']);
		$stats_gestural = explode(";", $_POST['stats_gestural']);
		$date = date('y-m-d h:m:s');
		$tactile=0;
		$gestural=1;
		
		// Insertion du nouveau joueur
		$req = $db_handle->prepare('INSERT OR IGNORE INTO player (pseudo,hand) VALUES (:pseudo,:main);');
		$req->execute(array('pseudo'=>$pseudo, 'main'=>$hand));

		// Insertion de la nouvelle partie
		$req = $db_handle->prepare('INSERT INTO game (pseudo_player, date) VALUES (:pseudo_player, :date);');
		$req->execute(array('pseudo_player'=>$pseudo, 'date'=>$date));
		$game_id = $db_handle->lastInsertId();
		echo "game_id=".$game_id."</br>";
		echo "tactile=".$tactile."</br>";

		// Insertion des statistiques sur chaque itération
		foreach($stats_tactile as $iteration) {
			$it = explode(",",$iteration);
			$req = $db_handle->prepare('INSERT INTO iteration (id_game,id_question,delay_answer,score,mode) VALUES (:id_game,:id_question,:delay_answer,:score,:mode);');
			$req->execute(array('id_game'=>$game_id, 'id_question'=>$it[0], 'delay_answer'=>$it[1],'score'=>$it[2],'mode'=>$tactile));
		}
		
		// Insertion des statistiques sur chaque itération
		foreach($stats_gestural as $iteration) {
			$it = explode(",",$iteration);
			$req = $db_handle->prepare('INSERT INTO iteration (id_game,id_question,delay_answer,score,mode) VALUES (:id_game,:id_question,:delay_answer,:score,:mode);');
			$req->execute(array('id_game'=>$game_id, 'id_question'=>$it[0], 'delay_answer'=>$it[1],'score'=>$it[2],'mode'=>$gestural));
		}
		
		$req = $db_handle->prepare("SELECT SUM(score) FROM iteration where id_game=:id_game AND mode=:mode;");
		$req->execute(array('id_game'=>$game_id, 'mode'=>$tactile));
		$_POST['score_tactile'] = $req->fetch();
		
		$req = $db_handle->prepare("SELECT SUM(score) FROM iteration where id_game=:id_game AND mode=:mode;");
		$req->execute(array('id_game'=>$game_id, 'mode'=>$gestural));
		$_POST['score_gestural'] = $req->fetch();
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>