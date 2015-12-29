<?php
	try {
		$db_handle = new PDO('sqlite:./db/oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		
/*
		$db_handle->exec("DROP TABLE player;");
		$db_handle->exec("DROP TABLE question;");
		$db_handle->exec("DROP TABLE game;");
		$db_handle->exec("DROP TABLE iteration;");
		$db_handle->exec("DROP TABLE buttons_size;");
		$db_handle->exec("DROP TABLE calibration_buttons;");
		$db_handle->exec("DROP TABLE calibration_post_it;");
*/
		
		
		// PLAYER
		$db_handle->exec("CREATE TABLE IF NOT EXISTS player (pseudo char(20) PRIMARY KEY, hand CHAR(5));");
		
		// CALIBRATION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS calibration_post_it (id INTEGER PRIMARY KEY AUTOINCREMENT, date TEXT, height_post_it INTEGER, width_post_it INTEGER, value_post_it TEXT);");
		
		// BUTTONS SIZE
		$db_handle->exec("CREATE TABLE IF NOT EXISTS calibration_buttons (id INTEGER PRIMARY KEY AUTOINCREMENT, date TEXT, size TEXT);");
		$db_handle->exec("CREATE TABLE IF NOT EXISTS buttons_size (size CHAR(10) PRIMARY KEY, height_buttons INTEGER, width_buttons INTEGER)");
		$db_handle->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('small','6','12');");
		$db_handle->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('medium','16','20');");
		$db_handle->exec("INSERT OR IGNORE INTO buttons_size (size, height_buttons, width_buttons) VALUES ('big','24','39');");
		
		// QUESTION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS question (id_question INTEGER PRIMARY KEY AUTOINCREMENT, question TEXT, answer INTEGER, shape TEXT);");
		
		// GAME
		$db_handle->exec("CREATE TABLE IF NOT EXISTS game (id_game INTEGER PRIMARY KEY AUTOINCREMENT, pseudo_player CHAR(20), date TEXT);");
		
		// ITERATION
		$db_handle->exec("CREATE TABLE IF NOT EXISTS iteration (id_iteration INTEGER PRIMARY KEY AUTOINCREMENT, id_game INTEGER, id_question INTEGER, delay_answer INTEGER, score INTEGER, mode INTEGER);");
		
		// INSERT QUESTION
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rond est bleu ?','false','circle-red');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rectangle est vert ?','true','rectangle-green');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le rond est rouge ?','false','circle-blue');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le triangle est vert ?','false','triangle-up-red');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('Le triangle est bleu ?','true','triangle-up-blue');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 6 = 21','false','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('3 x 9 = 28','false','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 7 = 28','true','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('256 / 2 = 123','false','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('7 x 8 = 49','false','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('4 x 8 = 32','true','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('12 x 3 = 36','true','transparent');");
		$db_handle->exec("INSERT OR IGNORE INTO question (question, answer, shape) VALUES ('162 x 2 = 324','true','transparent');");
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
?>