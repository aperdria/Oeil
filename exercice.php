<!-- Get the size of the button from the configuration -->
   <?php
	try {
		$db_handle = new PDO('sqlite:db/oeil.sqlite');
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$req = $db_handle->prepare("SELECT * FROM question");
		$req->execute();
		$questions = $req->fetchAll();
		
		$req = $db_handle->prepare("SELECT size FROM calibration_buttons ORDER BY date DESC LIMIT 1");
		$req->execute();
		$size_buttons = $req->fetch();
		if($size_buttons[0] == "small") {
			$class = "btn-exercice-sm";
		} else if($size_buttons[0] == "big") {
			$class = "btn-exercice-lg";
		} else {
			$class = "btn-exercice-md";
		} 
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
?>
<!-- EXERCICE -->
<section id="about" class="about-section">
    <div class="container">
        <div class="row" id="card">
			<div class="col-md-12">
				<div id="score"></div></br></br>
				<!-- Timer -->
				<div class="col-md-12">
					<div class="col-md-4"></div>
					<div class="col-md-4"><div class="flip-clock-wrapper clock"></div></div>
					<div class="col-md-4"></div>
				</div>
				</br>
				<!-- Buttons Yes and No -->
				<div id="buttons">
					<a href="#" onclick="next_yes()" id="button_yes" class="btn <?php echo $class ?> btn-default">Oui</a>
					<a href="#" onclick="next_no()" id="button_no" class="btn  <?php echo $class ?> btn-default">Non</a>
				</div>
				<!-- Question -->
				<div class="col-md-12"><div id="exercice"></div></div>
			 </div>
        </div>
    </div>
</section>