<?php
if (!empty($_POST))
{
	include_once("functions_db.php");
	
	try {
		$bdd = new PDO('sqlite:./oeil.sqlite');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if(!empty($_POST['width_post_it']) && !empty($_POST['height_post_it']) && !empty($_POST['value'])) {
			send_calib_post_it($bdd,$_POST['width_post_it'],$_POST['height_post_it'],$_POST['value']);
		}
		else if(!empty($_POST['size_buttons'])) {
			send_calib_buttons($bdd,$_POST['size_buttons']);
		}
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>