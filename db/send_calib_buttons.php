<?php
if (!empty($_POST))
{
	try {
		$db_handle = new PDO('sqlite:oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$size_buttons = $_POST['size_buttons'];
		$date = $_POST['date'];
		
		// Insertion de la nouvelle partie
		$req = $db_handle->prepare('INSERT INTO calibration_buttons (date, size) VALUES (:date, :size);');
		$req->execute(array('date'=>$date, 'size'=>$size_buttons));
	} catch (Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
} else {
	echo "post is empty";
}
?>