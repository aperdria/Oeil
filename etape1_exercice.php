<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projet Oeil</title>
    <script type="text/javascript">
        document.oncontextmenu = new Function("return false");
    </script>

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
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">		<input type="hidden" name="stats_tactile" id="stats_tactile" value="<?php echo $_POST['stats_tactile'] ?>">
	</form>
   
    <!-- jQuery -->
    <script src="./js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="./js/jquery.easing.min.js"></script>
    <script src="./js/scrolling-nav.js"></script>
    <script src="./js/flipclock.js"></script>
    
    <script src="./js/sql.js"></script>

    <script type="text/javascript">
    
    var stats_tactile = [];
    
    // Load question
    <?php
		try {
			$db_handle = new PDO('sqlite:oeil.sqlite');
			$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$req = $db_handle->prepare("SELECT * FROM question");
			$req->execute();
			$questions = $req->fetchAll();
		} catch (Exception $e) {
			die('Erreur : '.$e->getMessage());
		}
	?>
	
	// To display questions
    var questions = <?php echo json_encode($questions); ?>;  
    var i=0;
    var i_prev=0;
    
    // To display the score
    var cpt=0;
    var score_tactile=0;
	var clock;
	
	// To calculate delay between two clicks
	var d = new Date;
	var t = d.getTime();
	var lastClick = t;
	var delay = 0;
    
    // Display the first question
    i = Math.floor(Math.random()*questions.length);
	document.getElementById("exercice").innerHTML = '<h3>'+questions[i]['question']+'</h3><div id="'+questions[i]['shape']+'"></div>';
	document.getElementById("score").innerHTML = '0/'+cpt;

	// Start the timer
	clock();
    
    function next_yes() {
    
    	// Delay to click
    	d = new Date();
    	t = d.getTime();
    	delay = t - lastClick;
    	lastClick = t;
    	
    	// Check if the answer is correct
    	if(questions[i]['answer'] == "true") {
    		score_tactile++;
    		score=1;
    	} else {
	    	score=0;
    	}
    	
    	// Count the iteration in statistics
    	stats_tactile[cpt] = new Array(3);
		stats_tactile[cpt][0] = questions[i]['id_question'];
		stats_tactile[cpt][1] = delay;
		stats_tactile[cpt][2] = score;
		console.log(stats_tactile.join(';'));
		
		// Display a new question
		i_prev = i;
		while(i==i_prev)
			i = Math.floor(Math.random()*questions.length);
			
	    document.getElementById("exercice").innerHTML = '<h3>'+questions[i]['question']+'</h3><div id="'+questions[i]['shape']+'"></div>';
		document.getElementById("score").innerHTML = score_tactile+'/'+(cpt+1);
		cpt++;
    }
    
    function next_no() {
       	// Delay to click
    	d = new Date();
    	t = d.getTime();
    	delay = t - lastClick;
    	lastClick = t;
    
    	//Check if the answer is correct
    	if(questions[i]['answer'] == "false") {
    		score_tactile++;
    		score=1;
    	} else {
	    	score=0;
    	}
    	
    	// Count the iteration in statistics
    	stats_tactile[cpt] = new Array(3);
		stats_tactile[cpt][0] = questions[i]['id_question'];
		stats_tactile[cpt][1] = delay;
		stats_tactile[cpt][2] = score;
		console.log(stats_tactile.join(';'));
		
		// Display a new question
		i_prev = i;
		while(i==i_prev)
			i = Math.floor(Math.random()*questions.length);
			
	    document.getElementById("exercice").innerHTML = '<h3>'+questions[i]['question']+'</h3><div id="'+questions[i]['shape']+'"></div>';
		document.getElementById("score").innerHTML = score_tactile+'/'+(cpt+1);
		cpt++;
    }
		
	function clock() {
		clock = $('.clock').FlipClock(20, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
					var element = document.getElementById("stats_tactile");
					element.value = stats_tactile.join(';');
					element.form.submit();
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
