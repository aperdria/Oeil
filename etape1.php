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
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/scrolling-nav.css" rel="stylesheet">
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./css/flipclock.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

    <!-- Intro Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
				<div class="col-md-12">
					<h2 class="cover-heading">Etape 1</h2>
					<p class="lead">Bienvenue sur l'outil de test du projet Interaction.</br>Vous aurez dix secondes pour répondre aux questions qui vont vous être posées.</br>Entrez votre pseudo et appuyez sur commencer.</p>
					<form action="etape1_exercice.php" method="GET">
						<input type="text" placeholder="Votre pseudo" name="pseudo">
						<span class="help-block"></span>
						<p>Avec quelle main tapez-vous sur l'écran ?</p>
						<div class="radio">
						  <label><input type="radio" name="gauche">Gauche</label>
						  <label><input type="radio" name="droite">Droite</label>
						</div>
						<span class="help-block"></span>
						<button type="submit" class="btn btn-default">Commencer</button>
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
    <script src="./js/flipclock.js"></script>
    
    <script type="text/javascript">
    // TODO Externaliser dans un fichier XML
    var table = [
    	new Array("Le rond est bleu ?","circle-red","false"),
    	new Array("Le rectangle est vert ?","rectangle-green","true"),
    	new Array("Le rond est rouge ?","circle-blue","false"),
    	new Array("Le triangle est vert ?","triangle-up-red","false"),
    	new Array("Le triangle est bleu ?","triangle-up-blue","true"),
    	new Array("4*6=21 ?","","false"),
    	new Array("3*9=28 ?","","false"),
    	new Array("256/2=123 ?","","false"),
    	new Array("7*8=49 ?","","false"),
    	new Array("4*8=32 ?","","true"),
    	new Array("12*3=26 ?","","true"),
    	];
    	
    var parameters = location.search.substring(1).split("&");
    var temp = parameters[0].split("=");
    var pseudo = unescape(temp[1]);
    temp = parameters[1].split("=");
    var pourcentage_reussite_tactile = unescape(temp[1]);
		  
    var score=0;  
    var compteur = 0;
    var i=0;
    var pourcentage_reussite_gestuel=0;
	var clock;
    
    i = Math.floor(Math.random()*table.length);
	document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
	document.getElementById("pourcentage").innerHTML = '0% de réussite';

    
	clock();
    
    function next_yes() {
    	compteur++;
    	if(table[i][2] == "true")
    		score++;
    	i = Math.floor(Math.random()*table.length);
	    document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
		pourcentage_reussite_gestuel=Math.round((score*100)/compteur);
		document.getElementById("pourcentage").innerHTML = pourcentage_reussite_gestuel+'% de réussite';

    }
    
    function next_no() {
    	compteur++;
    	if(table[i][2] == "false")
			score++;
    	i = Math.floor(Math.random()*table.length);
	    document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
	    pourcentage_reussite_gestuel=Math.round((score*100)/compteur);
	    document.getElementById("pourcentage").innerHTML = pourcentage_reussite_gestuel+'% de réussite';
    }
		
	function clock() {
		clock = $('.clock').FlipClock(10, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
	        		pourcentage_reussite_gestuel=Math.round((score*100)/compteur);
			    	document.location.href = 'index.html?pseudo='+pseudo+'&pourcentage_reussite_tactile='+pourcentage_reussite_tactile+'&pourcentage_reussite_gestuel='+pourcentage_reussite_gestuel;
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
