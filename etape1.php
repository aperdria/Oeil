<!DOCTYPE html>
<html lang="en">


<?php include_once("head.php"); ?>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

    <!-- Intro Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row" id="card">
				<div class="col-md-12">
					<h2 class="cover-heading">Etape 1</h2>
					<p class="lead">Bienvenue sur l'outil de test du projet Interaction.</br>Vous aurez dix secondes pour répondre aux questions qui vont vous être posées.</br>Entrez votre pseudo et appuyez sur commencer.</p>
					<form action="etape1_exercice.php" method="POST" name="form" onsubmit="return checkForm()">
						<input type="text" placeholder="Votre pseudo" name="pseudo">
						<span class="help-block"></span>
						<p>Avec quelle main tapez-vous sur l'écran ?</p>
						<div class="radio">
						  <label><input type="radio" name="hand" value="left">Gauche</label>
						  <label><input type="radio" name="hand" value="right" checked>Droite</label>
						</div>
						<button type="submit" class="btn btn-default">Commencer</button>
						<div id="error"></div>
					</form>

				 </div>
            </div>
        </div>
    </section>

   
    <!-- jQuery -->
    <script src="./js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="./js/jquery.easing.min.js"></script>
    <script src="./js/scrolling-nav.js"></script>

	<script type="text/javascript">
	function checkForm () {
		if(document.form.pseudo.value == "") {
			document.getElementById("error").innerHTML = '<p style="color:red; padding-top:10px;">Vous devez entrer un pseudo valide.</p>';
			return false;
		}
		else {
			return true;
		}
	};
	</script>

</body>

</html>
