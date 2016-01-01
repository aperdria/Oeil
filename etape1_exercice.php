<!DOCTYPE html>
<html lang="en">


<?php include_once("head.php"); ?>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

	<!-- EXERCICE -->
    <?php include_once "exercice.php" ?>

	<!-- This form is used to send values to the next page, we send the pseudo, the hand and the statistics (id_question, score, delay_to_answer) contained in an array -->
	<form action="etape2.php" method="post">
		<input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>">
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">
		<input type="hidden" name="stats_tactile" id="stats_tactile" value="<?php echo $_POST['stats_tactile'] ?>">
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


	<!-- MAIN SCRIPT -->
    <script type="text/javascript">
    
    var stats_tactile = [];
   
	
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
			document.getElementById("correction").innerHTML = 'Vrai !';
			document.getElementById("correction").style.color = "green";
    	} else {
	    	score=0;
			document.getElementById("correction").innerHTML = 'Faux !';
			document.getElementById("correction").style.color = "red";
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
	    document.getElementById("score").innerHTML = 'Votre score actuel : '+score_tactile+'/'+(cpt+1);
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
			document.getElementById("correction").innerHTML = 'Vrai !';
			document.getElementById("correction").style.color = "green";
    	} else {
	    	score=0;
			document.getElementById("correction").innerHTML = 'Faux !';
			document.getElementById("correction").style.color = "red";
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
		document.getElementById("score").innerHTML = 'Votre score actuel : '+score_tactile+'/'+(cpt+1);
		cpt++;
    }
		
	function clock() {
		clock = $('.clock').FlipClock(5, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
		        	if(cpt==0) {
			        	document.location.href="index.php"
		        	} else {
						var element = document.getElementById("stats_tactile");
						element.value = stats_tactile.join(';');
						element.form.submit();
					}
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
