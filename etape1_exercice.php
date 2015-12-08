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

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

    <!-- Intro Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row" id="card">
				<div class="col-md-12">
					<div id="score"></div></br></br>
					<div class="col-md-12">
						<div class="col-md-4"></div>
						<div class="col-md-4"><div class="flip-clock-wrapper clock"></div></div>
						<div class="col-md-4"></div>
					</div><div id="buttons">
						<a href="#" onclick="next_yes()" class="btn btn-lg btn-default">Oui</a>
						<a href="#" onclick="next_no()" class="btn btn-lg btn-default">Non</a>
					</div>
					<div class="col-md-12"><div id="exercice"></div></div>
					
					
				 </div>
            </div>
        </div>
    </section>

	<form action="etape2.php" method="post">
		<input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>">
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">
		<input type="hidden" name="score_tactile" id="score_tactile">
	</form>
   
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
    	new Array("4x6=21 ?","","false"),
    	new Array("3x9=28 ?","","false"),
    	new Array("4x7=28 ?","","true"),
    	new Array("256/2=123 ?","","false"),
    	new Array("7x8=49 ?","","false"),
    	new Array("4x8=32 ?","","true"),
    	new Array("12x3=36 ?","","true"),
    	];
    	
    var parameters = location.search.substring(1).split("&");
    var temp = parameters[0].split("=");
    var pseudo = unescape(temp[1]);
		  
    var i=0;
    var cpt=1;
    var score_tactile=0;
	var clock;
    
    i = Math.floor(Math.random()*table.length);
	document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
	document.getElementById("score").innerHTML = '0/'+cpt;

    
	clock();
    
    function next_yes() {
    	if(table[i][2] == "true")
    		score_tactile++;
    	i = Math.floor(Math.random()*table.length);
	    document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
		document.getElementById("score").innerHTML = score_tactile+'/'+cpt;
		cpt++;
    }
    
    function next_no() {
    	if(table[i][2] == "false")
			score_tactile++;
    	i = Math.floor(Math.random()*table.length);
	    document.getElementById("exercice").innerHTML = '<h3>'+table[i][0]+'</h3><div id="'+table[i][1]+'"></div>';
		document.getElementById("score").innerHTML = score_tactile+'/'+cpt;
		cpt++;
    }
		
	function clock() {
		clock = $('.clock').FlipClock(20, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
					var element = document.getElementById("score_tactile");
					element.value = score_tactile;
					element.form.submit();
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
