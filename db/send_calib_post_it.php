<?php
if (!empty($_POST))
{
	try {
		$db_handle = new PDO('sqlite:oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$width_post_it = $_POST['width_post_it'];
		$height_post_it = $_POST['height_post_it'];
		$value = $_POST['value'];
		$date = $_POST['date'];
				
		// Insertion de la nouvelle partie
		$req = $db_handle->prepare('INSERT INTO calibration_post_it (date, height_post_it, width_post_it, value_post_it) VALUES (:date, :height_post_it, :width_post_it, :value);');
		$req->execute(array('date'=>$date, 'height_post_it'=>$height_post_it, 'width_post_it'=>$width_post_it, 'value'=>$value));
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>