<?php
	try {
		$db_handle = new PDO('sqlite:db/oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$req = $db_handle->prepare("
			SELECT *
			FROM
			(SELECT p.pseudo, sum(it.score) as score_tactile, avg(delay_answer) as delay, g.id_game
			FROM iteration it, game g, player p
			WHERE g.id_game = it.id_game and g.pseudo_player = p.pseudo and it.mode = 0
			GROUP BY  g.id_game
			ORDER BY score_tactile ASC)
			GROUP BY pseudo
			ORDER BY score_tactile DESC
			LIMIT 10;");
		$req->execute();
		$result = $req->fetchAll();
		$cpt=1;
		foreach ($result as $score) {
		echo '<tr><td>'.$cpt.'</td><td>'.$score[0].'</td><td>'.$score[1].'</td><td>'.(round($score[2]*0.001,2)).' seconde(s)</td></tr>';
		$cpt++;
		}
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
?>