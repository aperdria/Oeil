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
		<input type="hidden" name="game_id" id="game_id" value="<?php echo $_POST['game_id'] ?>">
		<!--<input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>">
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">
		<input type="hidden" name="stats_tactile" id="stats_tactile" value="<?php echo $_POST['stats_tactile'] ?>">
		<input type="hidden" name="stats_gestural" id="stats_gestural" value="<?php echo $_POST['stats_gestural'] ?>">-->
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

    <!-- Leap Motion -->
    <script src="./js/three.js"></script>
    <script src="./js/leap.min.js"></script>
    <script type="text/javascript" src="./js/donnees_leap.js"></script>


     <!-- Js gérant le Leap Motion-->
    <script>           
        //Gère les initialisations des boutons
        $(document).ready(function()
        {
            displayData = false;
        });

        //Chargement des positions des postits à partir du localStorage
        var monobjet_json = localStorage.getItem("positions1");
        if(monobjet_json != null)
        {
            positions1 = JSON.parse(monobjet_json);
            plane1 = createPlane(plane1,positions1);
        }
        monobjet_json = localStorage.getItem("positions2");
        if(monobjet_json != null)
        {
            positions2 = JSON.parse(monobjet_json);
            plane2 = createPlane(plane2,positions2);
        }
    </script>
    
    <script type="text/javascript">
    
    var stats_gestural = [];
		
    var pseudo = '<?php echo $_POST['pseudo']  ?>';  
    var hand = '<?php echo $_POST['hand'] ?>';  
    var stats_tactile = <?php echo json_encode($_POST['stats_tactile']); ?>;  
	
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
	document.getElementById("score").innerHTML = 'Votre score actuel : '+score_gestural+'/'+(cpt+1);

	// Start the timer
	clock();

	function touch_yes()
    {
        next_yes();
    }

    function touch_no()
    {
        next_no();
    }
    
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
			document.getElementById("correction").innerHTML = 'Vrai !';
			document.getElementById("correction").style.color = "green";
    	} else {
	    	score=0;
			document.getElementById("correction").innerHTML = 'Faux !';
			document.getElementById("correction").style.color = "red";
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
		document.getElementById("score").innerHTML = 'Votre score actuel : '+score_gestural+'/'+(cpt+1);

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
			document.getElementById("correction").innerHTML = 'Vrai !';
			document.getElementById("correction").style.color = "green";
    	} else {
	    	score=0;
			document.getElementById("correction").innerHTML = 'Faux !';
			document.getElementById("correction").style.color = "red";
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
		document.getElementById("score").innerHTML = 'Votre score actuel : '+score_gestural+'/'+(cpt+1);

		cpt++;
    }
		
	function clock() {
		clock = $('.clock').FlipClock(5, {
	        clockFace: 'MinuteCounter',
	        countdown: true,
	        callbacks: {
	        	stop: function() {
		        	if(cpt==0) {
			        	document.location.href="index.php";
		        	} else {
				        $.ajax({
			                type: 'POST',
			                url: 'db/send_stats.php',
			                data: 'pseudo='+pseudo+'&hand='+hand+'&stats_tactile='+stats_tactile+'&stats_gestural='+stats_gestural.join(';'),
			                dataType: 'html', 
			                success: function(data) {
								var element = document.getElementById("game_id");
								element.value = data;
								element.form.submit();
			                },
			                error: function(data) {
				                alert("Erreur dans l'enregistrement de votre score.");
				                document.location.href="index.php";
			                }
			            });
					}
	        	}
	        }
	    });
	}
		
	</script>

</body>

</html>
