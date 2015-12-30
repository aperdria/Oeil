<!-- Get the size of the button from the configuration -->
   <?php
	   include_once("db/functions_db.php");
	   $bdd = connexion();
	   $questions = get_questions($bdd);
	   $size_buttons = get_buttons_size($bdd);
		if($size_buttons == "small") {
			$class = "btn-exercice-sm";
		} else if($size_buttons == "big") {
			$class = "btn-exercice-lg";
		} else {
			$class = "btn-exercice-md";
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