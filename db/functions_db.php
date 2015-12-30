<?php

function connexion () {
	try {
		$bdd = new PDO('sqlite:./db/oeil.sqlite');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $bdd;
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
}

function get_best_score_tactile ($bdd) {
	$req = $bdd->prepare("
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
		return $result;
}

function get_best_score_gestural ($bdd) {
	$req = $bdd->prepare("
			SELECT *
			FROM
			(SELECT p.pseudo, sum(it.score) as score_gestural, avg(delay_answer) as delay, g.id_game
			FROM iteration it, game g, player p
			WHERE g.id_game = it.id_game and g.pseudo_player = p.pseudo and it.mode = 1
			GROUP BY  g.id_game
			ORDER BY score_gestural ASC)
			GROUP BY pseudo
			ORDER BY score_gestural DESC
			LIMIT 10;");
		$req->execute();
		$result = $req->fetchAll();
		return $result;
}

function send_stats ($bdd, $pseudo, $hand, $stats_tactile, $stats_gestural) {
	$date = date('y-m-d h:m:s');
	$tactile=0;
	$gestural=1;
	$calibration_buttons = get_last_calib_buttons($bdd);
	$calibration_post_it = get_last_calib_post_it($bdd);
	
	// Insertion du nouveau joueur
	$req = $bdd->prepare('INSERT OR IGNORE INTO player (pseudo,hand) VALUES (:pseudo,:main);');
	$req->execute(array('pseudo'=>$pseudo, 'main'=>$hand));

	// Insertion de la nouvelle partie
	$req = $bdd->prepare('INSERT INTO game (pseudo_player, date, calibration_post_it, calibration_buttons) VALUES (:pseudo_player, :date, :calibration_post_it, :calibration_buttons);');
	$req->execute(array('pseudo_player'=>$pseudo, 'date'=>$date, 'calibration_post_it'=>$calibration_post_it, 'calibration_buttons'=>$calibration_buttons));
	$game_id = $bdd->lastInsertId();

	// Insertion des statistiques sur chaque itération
	foreach($stats_tactile as $iteration) {
		$it = explode(",",$iteration);
		$req = $bdd->prepare('INSERT INTO iteration (id_game,id_question,delay_answer,score,mode) VALUES (:id_game,:id_question,:delay_answer,:score,:mode);');
		$req->execute(array('id_game'=>$game_id, 'id_question'=>$it[0], 'delay_answer'=>$it[1],'score'=>$it[2],'mode'=>$tactile));
	}
	
	// Insertion des statistiques sur chaque itération
	foreach($stats_gestural as $iteration) {
		$it = explode(",",$iteration);
		$req = $bdd->prepare('INSERT INTO iteration (id_game,id_question,delay_answer,score,mode) VALUES (:id_game,:id_question,:delay_answer,:score,:mode);');
		$req->execute(array('id_game'=>$game_id, 'id_question'=>$it[0], 'delay_answer'=>$it[1],'score'=>$it[2],'mode'=>$gestural));
	}
	
	return $game_id;
}

function get_score_tactile_from_gameid ($bdd, $game_id) {
	$req = $bdd->prepare("SELECT SUM(score) FROM iteration where id_game=:id_game AND mode=:mode;");
	$req->execute(array('id_game'=>$game_id, 'mode'=>0));
	$res = $req->fetch();
	return ($res[0]);
}

function get_score_gestural_from_gameid ($bdd, $game_id) {
	$req = $bdd->prepare("SELECT SUM(score) FROM iteration where id_game=:id_game AND mode=:mode;");
	$req->execute(array('id_game'=>$game_id, 'mode'=>1));
	$res = $req->fetch();
	return ($res[0]);
}

function send_calib_post_it ($bdd,$width_post_it,$height_post_it,$value) {
	$req = $bdd->prepare('INSERT INTO calibration_post_it (height_post_it, width_post_it, value_post_it) VALUES (:height_post_it, :width_post_it, :value);');
	$req->execute(array('height_post_it'=>$height_post_it, 'width_post_it'=>$width_post_it, 'value'=>$value));
}

function send_calib_buttons ($bdd,$size_buttons) {
	$req = $bdd->prepare('INSERT INTO calibration_buttons (size) VALUES (:size);');
	$req->execute(array('size'=>$size_buttons));
}

function get_last_calib_post_it ($bdd) {
	$req = $bdd->prepare("SELECT * FROM calibration_post_it ORDER BY id DESC LIMIT 1");
	$req->execute();
	$result = $req->fetch();
	return($result[0]);
}

function get_last_calib_buttons ($bdd) {
	$req = $bdd->prepare("SELECT * FROM calibration_buttons ORDER BY id DESC LIMIT 1");
	$req->execute();
	$result = $req->fetch();
	return($result[0]);
}

function get_questions ($bdd) {
	$req = $bdd->prepare("SELECT * FROM question");
	$req->execute();
	return($req->fetchAll());
}

function get_buttons_size ($bdd) {
	$req = $bdd->prepare("SELECT size FROM calibration_buttons ORDER BY id DESC LIMIT 1");
	$req->execute();
	$size_buttons = $req->fetch();
	return($size_buttons[0]);
}

function get_avg_delay_by_buttons_size ($bdd) {
	$req = $bdd->prepare("
		SELECT AVG(delay) as delay, size
		FROM(
		SELECT  avg(delay_answer) as delay, g.id_game, cb.size
		FROM iteration it, game g, calibration_buttons cb
		WHERE g.id_game = it.id_game and it.mode = 0 and cb.id=g.calibration_buttons
		GROUP BY  g.id_game)
		GROUP BY size
		ORDER BY size DESC");
	$req->execute();
	return($req->fetchAll());
}

function get_avg_score_by_buttons_size ($bdd) {
	$req = $bdd->prepare("
		SELECT AVG(score) as score, size
		FROM(
		SELECT  sum(it.score) as score, g.id_game, cb.size
		FROM iteration it, game g, calibration_buttons cb
		WHERE g.id_game = it.id_game and it.mode = 0 and cb.id=g.calibration_buttons
		GROUP BY  g.id_game)
		GROUP BY size
		ORDER BY size DESC");
	$req->execute();
	return($req->fetchAll());
}

function get_avg_delay_by_post_it_size ($bdd) {
	$req = $bdd->prepare("
		SELECT AVG(delay) as delay, width, height
		FROM(
		SELECT  avg(delay_answer) as delay, g.id_game, cp.height_post_it as height, cp.width_post_it as width
		FROM iteration it, game g, calibration_post_it cp
		WHERE g.id_game = it.id_game and it.mode = 1 and cp.id=g.calibration_post_it
		GROUP BY  g.id_game)
		GROUP BY width, height");
	$req->execute();
	return($req->fetchAll());
}

function get_avg_score_by_post_it_size ($bdd) {
	$req = $bdd->prepare("
		SELECT AVG(score) as score, width, height
		FROM(
		SELECT  sum(score) as score, g.id_game, cp.height_post_it as height, cp.width_post_it as width
		FROM iteration it, game g, calibration_post_it cp
		WHERE g.id_game = it.id_game and it.mode = 1 and cp.id=g.calibration_post_it
		GROUP BY  g.id_game)
		GROUP BY width, height");
	$req->execute();
	return($req->fetchAll());
}

?>