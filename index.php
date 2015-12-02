<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projet Oeil</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

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
                <a class="navbar-brand page-scroll" href="#page-top">OEil</a>
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
                    
                    <h4>Les trois meilleurs testeurs du jour : </h4>
                    <?php
						try {
						   $db_handle = new PDO('sqlite:db.sqlite');
						   $db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						   $results = $db_handle->exec("CREATE TABLE IF NOT EXISTS scores (pseudo VARCHAR PRIMARY KEY, main VARCHAR, score_tactile INTEGER, score_gestuel INTEGER);");
						   $pseudo = $_GET['pseudo'];
						   $main = 'droite';
						   $score_tactile = $_GET['score_tactile'];
						   $score_gestuel = $_GET['score_gestuel'];
						   if(!empty($pseudo) and !empty($main) and !empty($score_tactile) and !empty($score_gestuel)) {
							   $req = $db_handle->prepare('INSERT INTO scores (pseudo,main,score_tactile,score_gestuel) VALUES (:pseudo,:main,:score_tactile,:score_gestuel);');
							   $req->execute(array('pseudo'=>$pseudo,'main'=>$main,'score_tactile'=>$score_tactile,'score_gestuel'=>$score_gestuel));
						   }
						   $req = $db_handle->prepare("SELECT * FROM scores ORDER BY score_gestuel DESC LIMIT 3;");
						   $req->execute();
						   $result = $req->fetchAll();
						   $i=1;
						   foreach ($result as $score) {
							   echo '<h5>'.$i.'. '.$score[0].'</h5>';
							   $i++;
						   }
						} catch (Exception $e) {
						   die('Erreur : '.$e->getMessage());
						}
						?>
                </div>
                <div class="col-lg-2"></div>
                
  
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="scores" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Scores</h1>
						<p id="score"></p>
						<!--<a href="#" onclick="clearScore()" class="btn btn-lg btn-default">Réinitialiser</a>-->
						
						<table class="table table-striped">
						<thead>
						<tr>
						<th>Pseudo</th>
						<th>Score Tactile</th>
						<th>Score Leap</th>
						</tr>
						</thead>
						<tbody id="score_table">
	</script>
	
	<?php
		try {
		   $db_handle = new PDO('sqlite:db.sqlite');
		   $db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   $req = $db_handle->prepare("SELECT * FROM scores ORDER BY score_gestuel DESC;");
		   $req->execute();
		   $result = $req->fetchAll();
		   foreach ($result as $score) {
			   echo '<tr><td>'.$score[0].'</td><td>'.$score[2].'</td><td>'.$score[3].'</td></tr>';
		   }
		} catch (Exception $e) {
		   die('Erreur : '.$e->getMessage());
		}
		?>						
						</tbody>
						</table>
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
                    <a class="btn btn-default page-scroll" href="#contact">Contactez-nous</a>
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
                    <h4>Thalès</h4>
                    <p>Thalès Communication & Security</p>
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
    
    <script type="text/javascript">
    // TODO Faire marcher la sauvegarde SQLite
    
    if(location.search.length > 1 ) {
	  	var parameters = location.search.substring(1).split("&");
	    var temp = parameters[0].split("=");
	    var pseudo = unescape(temp[1]);
	    temp = parameters[1].split("=");
		var score_tactile = unescape(temp[1]);
	    temp = parameters[2].split("=");
		var score_gestuel = unescape(temp[1]);
		if(score_tactile != 'undefined' && score_gestuel != 'undefined')
			showScore();
		}
					
	  function showScore() {
	    document.getElementById("score").innerHTML = pseudo + ", votre nombre de bonnes réponses est de " + score_tactile + " avec les boutons, et de "+score_gestuel+" avec les post-it." ;
	  }
	
	function loadScoreHtml5 () {
		html5sql.openDatabase("db","Score Database", 5*1024*1024);
		html5sql.process(["CREATE TABLE IF NOT EXISTS scores (pseudo VARCHAR PRIMARY KEY, score_tactile INTEGER, score_gestuel INTEGER);",
		"INSERT INTO scores VALUES ('Amelie', 45, 75);"],
		function() {
			console.log("Created table");
		}, function(error, statement) {
			console.log("Failed to create table" + error.msg);
		});
	}
	
		function showTable(){
		
			html5sql.process(["SELECT * FROM scores;"],
				function(transaction, results, rowsArray){
					for(var i = 0; i < rowsArray.length; i++){
						console.log("<li>Retrieved" +rowsArray[i].name+"</li>");
					}
					console.log("<li>Done selecting data</li>");
				},
				function(error, statement){
					console.log("<li>"+error.message+" Occured while processing: "+statement+"</li>");
				}
			);
		}
	
	function loadScore () {
		var SQL = window.SQL;
		var xhr = new XMLHttpRequest();
		var contents;
		xhr.open('GET', './db.sqlite', true);
		xhr.responseType = 'arraybuffer';
		xhr.onload = function(e) {
			var uInt8Array = new Uint8Array(xhr.response);
			var db = new SQL.Database(uInt8Array);
			
			// db.run("CREATE TABLE scores (pseudo, score_tactile, score_gestuel));
			
			if(location.search.length > 1) 
				db.run("INSERT INTO score VALUES (?,?,?)", [pseudo,score_tactile,score_gestuel]);
			
			contents = db.exec("SELECT * FROM score");
			var table = "";
			table += ('<tr><td>Amélie</td><td>67%</td><td>80%</td></tr>');
			table += ('<tr><td>Nico</td><td>62%</td><td>92%</td></tr>');
			/*
			console.log(JSON.stringify(contents));
			for (var item in contents.values) {
				console.log("ok");
				table += ('<tr><td>'+'test'+'</td><td>'+item[0]+'</td><td>'+item[1]+'</td></tr>');
				console.log(item);
			}*/
			console.log(contents);
			console.log(table);
			document.getElementById("score_table").innerHTML = table;
			var data = db.export();
			var buffer = new Buffer(data);
			fs.writeFileSync("db.sqlite", buffer);
		};
		xhr.send();
		console.log(contents);
	}
		
	


</body>

</html>
