<?php

function create_database ($reinitialize_score, $reinitialize_calibration) {
	try {
		if(basename(dirname(__FILE__)) == "db")
			$bdd = new PDO('sqlite:./db/oeil.sqlite');
		else
			$bdd = new PDO('sqlite:./db/oeil.sqlite');

		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if($reinitialize_score) {
				$bdd->exec("DROP TABLE IF EXISTS player;");
				$bdd->exec("DROP TABLE IF EXISTS question;");
				$bdd->exec("DROP TABLE IF EXISTS game;");
				$bdd->exec("DROP TABLE IF EXISTS iteration;");
		}
		
		if($reinitialize_calibration) {
				$bdd->exec("DROP TABLE IF EXISTS buttons_size;");
				$bdd->exec("DROP TABLE IF EXISTS calibration_buttons;");
				$bdd->exec("DROP TABLE IF EXISTS calibration_post_it;");
		}
		
		
		// PLAYER
		$bdd->exec("CREATE TABLE IF NOT EXISTS player (pseudo char(20) PRIMARY KEY, hand CHAR(5));");
		
		// CALIBRATION
		$bdd->exec("CREATE TABLE IF NOT EXISTS calibration_post_it (id INTEGER PRIMARY KEY AUTOINCREMENT, height_post_it INTEGER, width_post_it INTEGER, value_post_it TEXT);");
		
		// BUTTONS SIZE
		$bdd->exec("CREATE TABLE IF NOT EXISTS calibration_buttons (id INTEGER PRIMARY KEY AUTOINCREMENT, size TEXT);");
		$bdd->exec("CREATE TABLE IF NOT EXISTS buttons_size (size CHAR(10) PRIMARY KEY, height_buttons INTEGER, width_buttons INTEGER)");
		$bdd->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('small','6','12');");
		$bdd->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('medium','16','20');");
		$bdd->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('big','24','39');");
		
		// QUESTION
		$bdd->exec("CREATE TABLE IF NOT EXISTS question (id_question INTEGER PRIMARY KEY AUTOINCREMENT, question TEXT, answer INTEGER, shape TEXT);");
		
		// GAME
		$bdd->exec("CREATE TABLE IF NOT EXISTS game (id_game INTEGER PRIMARY KEY AUTOINCREMENT, pseudo_player CHAR(20), date TEXT, calibration_post_it INTEGER, calibration_buttons INTEGER);");
		
		// ITERATION
		$bdd->exec("CREATE TABLE IF NOT EXISTS iteration (id_iteration INTEGER PRIMARY KEY AUTOINCREMENT, id_game INTEGER, id_question INTEGER, delay_answer INTEGER, score INTEGER, mode INTEGER);");
		
		// INSERT QUESTION
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rond est bleu ?','false','circle-red');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rectangle est vert ?','true','rectangle-green');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rond est rouge ?','false','circle-blue');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le triangle est vert ?','false','triangle-up-red');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le triangle est bleu ?','true','triangle-up-blue');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 6 = 21','false','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('3 x 9 = 28','false','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 7 = 28','true','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('256 / 2 = 123','false','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('7 x 8 = 49','false','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 8 = 32','true','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('12 x 3 = 36','true','transparent');");
		$bdd->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('162 x 2 = 324','true','transparent');");
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>