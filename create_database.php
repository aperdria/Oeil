<?php
	try {
		$db_handle = new PDO('sqlite:oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		/*
		$db_handle->exec("DROP TABLE player;");
		$db_handle->exec("DROP TABLE question;");
		$db_handle->exec("DROP TABLE calibration;");
		$db_handle->exec("DROP TABLE game;");
		$db_handle->exec("DROP TABLE iteration;");
		*/
		
		// PLAYER
		$db_handle->exec("CREATE TABLE IF NOT EXISTS player (pseudo char(20) PRIMARY KEY, hand CHAR(5));");
		
		// CALIBRATION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS calibration (id_calibration INTEGER PRIMARY KEY AUTOINCREMENT, date TEXT, size_post_it INTEGER, size_buttons INTEGER);");
		
		// QUESTION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS question (id_question INTEGER PRIMARY KEY AUTOINCREMENT, question TEXT, answer INTEGER, shape TEXT);");
		
		// GAME
		$db_handle->exec("CREATE TABLE IF NOT EXISTS game (id_game INTEGER PRIMARY KEY AUTOINCREMENT, pseudo_player CHAR(20), date TEXT);");
		
		// ITERATION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS iteration (id_iteration INTEGER PRIMARY KEY AUTOINCREMENT, id_game INTEGER, id_question INTEGER, delay_answer INTEGER, score INTEGER, mode INTEGER);");
		
		// INSERT QUESTION
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('Le rond est bleu ?','false','circle-red');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('Le rectangle est vert ?','true','rectangle-green');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('Le rond est rouge ?','false','circle-blue');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('Le triangle est vert ?','false','triangle-up-red');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('Le triangle est bleu ?','true','triangle-up-blue');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('4 x 6 = 21','false','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('3 x 9 = 28','false','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('4 x 7 = 28','true','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('256 / 2 = 123','false','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('7 x 8 = 49','false','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('4 x 8 = 32','true','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('12 x 3 = 36','true','');");
		$db_handle->exec("INSERT INTO question (question, answer, shape) VALUES ('162 x 2 = 324','true','');");
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
?>