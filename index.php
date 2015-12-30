<!DOCTYPE html>
<html lang="en">


<?php
	include_once("head.php");
?>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">OEil</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">A propos</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#scores">Scores</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#infos">Plus d'infos sur le projet</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                    <!-- A supprimer dans la version finale -->
                        <a class="page-scroll" href="config.php"><i>Calibrage</i></a>
                    </li>
                    <li>
                    <!-- A supprimer dans la version finale -->
                        <a class="page-scroll" href="statistiques.php"><i>Statistiques</i></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <section id="about" class="intro-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <h1 id="main-title">Projet Oeil</h1>

                    
                    <div class="col-lg-3"></div>
                    <h2>Optimisation des Espaces Identifiés Libres</h2>
                </br>
                    <p class="lead">Participez à une expérience innovante autour des nouveaux modes d'interactions Homme-Machine.</p></br>
                    <a class="btn btn-default btn-begin page-scroll" href="etape1.php"><h4>Commencer l'expérience</h4></a></br></br>
                    <a class="btn btn-default page-scroll" href="#scores">Voir les scores</a>
                    <a class="btn btn-default page-scroll" href="#infos">Obtenir plus d'infos</a></br></br> 
                </div>
                <div class="col-lg-2"></div>
                
  
            </div>
        </div>
    </section>
    
	<?php 
		include_once("db/functions_db.php");
		$bdd = connexion();
		include_once "db/create_database.php";
		create_database(false, false);
	?>
			
    <section id="scores" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Meilleurs scores</h1>
						<!-- Initialize database and send statistics if someone has just played -->
						<?php
							if(!empty($_POST)) {
								$pseudo = $_POST['pseudo'];
								$hand = $_POST['hand'];
								$stats_tactile = explode(";", $_POST['stats_tactile']);
								$stats_gestural = explode(";", $_POST['stats_gestural']);
								$game_id = send_stats ($bdd, $pseudo, $hand, $stats_tactile, $stats_gestural);
								$score_tactile_player = get_score_tactile_from_gameid($bdd,$game_id);
								$score_gestural_player = get_score_gestural_from_gameid($bdd,$game_id);
								echo '<h3 style="color:#87ba76">'.$pseudo.', votre score est de '.$score_tactile_player.' en tactile,  de '.$score_gestural_player.' en gestuel.</h3>';
							}
						?>
						
						
                <div class="col-lg-6 col-md-6">
                <?php
					$best_score_tactile = get_best_score_tactile($bdd);
					$best_score_gestural = get_best_score_gestural($bdd);
				?>
                <h4>Scores en utilisant l'écran tactile</h4>
						<table class="table table-striped">
						<thead>
							<tr>
							<th></th>
							<th>Pseudo</th>
							<th>Score Tactile</th>
							<th>Vitesse moyenne de clic</th>
							</tr>
						</thead>
						<tbody id="score_table">
						<?php 
						$cpt=1;
								foreach ($best_score_tactile as $score) {
									echo '<tr><td>'.$cpt.'</td><td>'.$score[0].'</td><td>'.$score[1].'</td><td>'.(round($score[2]*0.001,2)).' seconde(s)</td></tr>';
									$cpt++;
								}
							?>		
						</tbody>
						</table>
                </div>
                
                <div class="col-lg-6 col-md-6">
                <h4>Scores en utilisant les gestes</h4>
						<table class="table table-striped">
						<thead>
							<tr>
							<th></th>
							<th>Pseudo</th>
							<th>Score Gestuel</th>
							<th>Vitesse moyenne de clic</th>
							</tr>
						</thead>
						<tbody id="score_table">
							<?php 
							$cpt=1;
								foreach ($best_score_gestural as $score) {
									echo '<tr><td>'.$cpt.'</td><td>'.$score[0].'</td><td>'.$score[1].'</td><td>'.(round($score[2]*0.001,2)).' seconde(s)</td></tr>';
									$cpt++;
								}
							?>				
						</tbody>
						</table>
                </div>
						
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="infos" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <h2>Optimisation des Espaces Identifiés Libres</h2>
                    <p>Ce projet s’inscrit dans le cadre d’un partenariat entre l’Université de Technologie de Compiègne et Thales Communications & Security. En effet, Thales a lancé en 2015 une phase d’étude amont, le projet VIVEA (Véhicules Info-Valorisés à Ergonomie Avancée), dont le but est de déterminer les solutions technologiques innovantes permettant de répondre aux besoins opérationnels de l’Armée de Terre. Ces nouvelles solutions doivent permettre à l’armée d’accroître la protection de ses soldats, d’accélérer les processus décisionnels, et d’améliorer la préparation opérationnelle de ses missions. Ainsi, le projet s’articule autour de trois grands axes :</br></br>
                    Évaluation du gain opérationnel, de la maturité et la pertinence des technologies innovantes</br>
                    Évaluation d’une nouvelle organisation des postes d’équipages des futurs véhicules de l’armée de terre</br>
                    Évaluation dans un contexte opérationnel des différentes innovations afin de mesurer le gain réel de leurs utilisations</br></br>
                    L’objectif principal de ce projet est de réaliser une preuve de concept autour des nouveaux modes d’interactions Homme-Machine de type contrôle gestuel dans un véhicule de type blindé. En effet, de nombreuses informations capitales sont transmises aux opérateurs et aux décisionnaires par le biais d’écrans de contrôle tactiles à l’intérieur de ces véhicules. Or, de part la nature de l’environnement (environnement confiné, mobile et bruyant), il est parfois difficile d’interagir avec ce type d’interface une fois sur le terrain. L’objectif de ce projet serait donc d’exploiter les nombreux espaces disponibles à l’intérieur de ces véhicules blindés, afin de les transformer en interface de commande, qui pourraient être utilisées pour faciliter les interactions
des opérateurs sur le terrain.</p>
                    <a class="btn btn-default page-scroll" href="#contact">Nous contacter</a>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </section>
    
        <!-- Services Section -->
    <section id="contact" class="about-section">
        <div class="container">
			<div class="row">
                <div class="col-lg-12">
                    <h1>Contact</h1>
                    <h4></h4>
                    <h4></h4>
                </div>
                <div class="col-lg-6">
                     <img src="./img/thales.png" alt="" class="img-responsive center-block" style="width:50%">
                    <h3>Porteur de projet</h3>
                    <h4>Thales</h4>
                    <p>Thales Communication & Security</p>
                    <p>Marc Dehondt</p>
                </div>
                <div class="col-lg-6">
	                     <img src="./img/utc.png" alt="" class="img-responsive center-block" style="width:50%">
                    <h3>Réalisation</h3>
                    <h4>UTC</h4>
                    <p>Amélie Perdriaud</p>
                    <p>Nicolas Lhomme</p>
                </div>
                
            </div>
		</div>
    </section>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>

</body>

</html>
