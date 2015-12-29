<!DOCTYPE html>
<html lang="en">

<?php include_once("head.php"); ?>
	

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

	
	<!-- EXERCICE (Same than exercice 1) -->
    <?php include_once "exercice.php" ?>


	<!-- This form is used to send values to the next page, we send the pseudo, the hand and the statistics (id_question, score, delay_to_answer) contained in an array -->
	<form action="index.php#scores" method="post">
		<input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>">
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">
		<input type="hidden" name="stats_tactile" id="stats_tactile" value="<?php echo $_POST['stats_tactile'] ?>">
		<input type="hidden" name="stats_gestural" id="stats_gestural" value="<?php echo $_POST['stats_gestural'] ?>">
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
    
    var stats_gestural = [];
	
	// To display questions
    var questions = <?php echo json_encode($questions); ?>;  
    var i=0;
    var i_prev=0;
    
    // To display the score
    var cpt=0;
    var score_gestural=0;
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
    		score_gestural++;
    		score=1;
    	} else {
	    	score=0;
    	}
    	
    	// Count the iteration in statistics
    	stats_gestural[cpt] = new Array(3);
		stats_gestural[cpt][0] = questions[i]['id_question'];
		stats_gestural[cpt][1] = delay;
		stats_gestural[cpt][2] = score;
		
		// Display a new question
		i_prev = i;
		while(i==i_prev)
			i = Math.floor(Math.random()*questions.length);
			
	    document.getElementById("exercice").innerHTML = '<h3>'+questions[i]['question']+'</h3><div id="'+questions[i]['shape']+'"></div>';
		document.getElementById("score").innerHTML = score_gestural+'/'+(cpt+1);
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
    		score_gestural++;
    		score=1;
    	} else {
	    	score=0;
    	}
    	
    	// Count the iteration in statistics
    	stats_gestural[cpt] = new Array(3);
		stats_gestural[cpt][0] = questions[i]['id_question'];
		stats_gestural[cpt][1] = delay;
		stats_gestural[cpt][2] = score;
		console.log(stats_gestural.join(';'));
		
		// Display a new question
		i_prev = i;
		while(i==i_prev)
			i = Math.floor(Math.random()*questions.length);
			
	    document.getElementById("exercice").innerHTML = '<h3>'+questions[i]['question']+'</h3><div id="'+questions[i]['shape']+'"></div>';
		document.getElementById("score").innerHTML = score_gestural+'/'+(cpt+1);
		cpt++;
    }
		
	function clock() {
		clock = $('.clock').FlipClock(10, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
		        	if(cpt==0) {
			        	document.location.href="index.php"
		        	} else {
						var element = document.getElementById("stats_gestural");
						element.value = stats_gestural.join(';');
						element.form.submit();
					}
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
