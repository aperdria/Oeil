<!DOCTYPE html>
<html lang="en">


<?php include_once("head.php"); ?>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


    <?php include_once "menu_min.php" ?>
    


    <!-- Intro Section -->
    <section id="about" class="about-section">
        <div class="container">
         <div class="row">
         	<?php 
					include_once("db/functions_db.php");
					$bdd = connexion();
					$size_buttons = "medium";
					$size_buttons = get_buttons_size($bdd);
				?>
				<div class="col-md-12">
					<h3 class="cover-heading" id="config">Configuration de l'expérience</h3>
					<p class="lead">Cette page vous permet de configurer la taille des boutons tels qu'ils sont affichés à l'écran, et de calibrer l'espace de capture, c'est à dire les post-it destinés à remplacer ces boutons.</p>
				</div>
				<div class="col-md-8 col-md-offset-2">
						<h4 class="cover-heading">Réglage de la taille des boutons</h4>
					<p class="lead2">Sélectionner une taille ci-dessous. Les boutons "Oui" et "Non" apparaîtront de cette taille pendant l'expérience.</p>
					<p id="success_btn" style="color:green;"></p>
					<div class="col-md-12">						
						<a href="#" onclick="changeSize('small','Petit')" id="button_sm" class="btn btn-exercice-sm btn-default <?php if($size_buttons=="small") echo "selected"?> ">Petit</a>
						<a href="#" onclick="changeSize('medium','Moyen')" id="button_md" class="btn btn-exercice-md btn-default <?php if($size_buttons=="medium") echo "selected"?> ">Moyen</a>
						<a href="#" onclick="changeSize('big','Gros')" id="button_lg" class="btn btn-exercice-lg btn-default <?php if($size_buttons=="big") echo "selected"?> ">Gros</a>
					</div>
				</div>
         </div>
            <div class="row">
				<div class="col-md-12">
						<h4 class="cover-heading" id="calibrage">Calibrage de l'espace de capture</h4>
					<p class="lead2">Pour chaque angle de la future interface, positionnez votre index puis cliquez sur le bouton correspondant à cet angle. Une fois les quatre angles créés, appuyez sur le bouton "Créer le bouton". Vous devez faire la manipulation pour chacun des deux boutons.</p>
					<p id="success" style="color:green;"></p>
					<p id="error" style="color:red;"></p>
					<a href="#calibrage" class="btn btn-lg btn-default" id="touch-top-left" style="width:150px">Top Left</a>
      				<a href="#calibrage" class="btn btn-lg btn-default" id="touch-top-right" style="width:150px">Top Right</a>
      				<br>
      				<a href="#calibrage" class="btn btn-lg btn-default" id="touch-bottom-left" style="width:150px">Bottom Left</a>
      				<a href="#calibrage" class="btn btn-lg btn-default" id="touch-bottom-right" style="width:150px">Bottom Right</a>
      				<br><br>
      				<a href="#calibrage" class="btn btn-lg btn-default" id="create-plane1">Créer le bouton OUI</a>
      				<a href="#calibrage" class="btn btn-lg btn-default" id="create-plane2">Créer le bouton NON</a>
				</div>
				 
				 
				<div class="col-md-12"></br>
                    <svg id="myCanvas" width="200" height="200" background="green">
                        <rect id ="rect1" width="200" height="200" fill="#F7230C" opacity="0.9"/>
                        <circle id="circle1" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="80" y="20" fill="black">OUI</text>
                    </svg>

                    <svg id="myCanvas2" width="200" height="200" background="green">
                        <rect id ="rect2" width="200" height="200" fill="#F7230C" opacity="0.9"/>
                        <circle id="circle2" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="80" y="20" fill="black">NON</text>
                    </svg>
                </div>
                        
				<div class="col-md-12">
                    <div class="col-md-6">
                        <h4><b>Mains</b></h4>
                        <div id="handData"></div>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="col-md-6">
                        <h4><b>Doigts</b></h4>
                        <div id="pointableData"></div>
                        <div style="clear:both;"></div>
                    </div>
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

    <!-- Leap Motion -->
    <script src="./js/three.js"></script>
	<script src="./js/leap.min.js"></script>
	<script type="text/javascript" src="./js/donnees_leap.js"></script>

		<script type="text/javascript">
			function changeSize(size,size_fr) {
	            $.ajax({
	                type: 'POST',
	                url: 'db/send_calib.php',
	                data: 'size_buttons='+size,
	                dataType: 'html', 
	                success: function(data) {
						$("#success_btn").text("Taille des boutons réglée sur " + size_fr);
	                },
	                error: function(data) {
		                $("#success").text("");
						$("#error").text(data);
	                }
	            });
	            
	            $("#button_sm").css('background-color','#ffffff');
	            $("#button_md").css('background-color','#ffffff');
	            $("#button_lg").css('background-color','#ffffff');
	            if(size=="small") {
		            $("#button_sm").css('background-color','#cccccc');
	            } else if(size=="medium") {
		            $("#button_md").css('background-color','#cccccc');
	            } else if(size=="big") {
		            $("#button_lg").css('background-color','#cccccc');
	            }
			};
		</script>
		<script type="text/javascript">

			//Gère les initialisations des boutons, des éléments du canvas à l'ouverture de la page
		    $(document).ready(function()
		    {
		    	displayData = true;
		        assignButtons();
		        circle1 = $("#circle1");
		        circle2 = $("#circle2");
		        rect1 = $("#rect1");
		        rect2 = $("#rect2");
		    });

			//localStorage.clear()   //A décommenter pour clear le localStorage
			
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

		    //enregistre les positions selon l'appui sur le bouton
		    function assignButtons()
		    {
		    
		        $("#touch-top-left").click(function(){
		            positions.topLeft = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],    //Position au bout du premier doigt sur l'axe x
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.topLeft: "+positions.topLeft);
		        });


		        $("#touch-top-right").click(function(){
		            positions.topRight = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.topRight: "+positions.topRight);
		        });

		        $("#touch-bottom-left").click(function(){
			        positions.bottomLeft = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.bottomLeft: "+positions.bottomLeft);
		        });


		        $("#touch-bottom-right").click(function(){
		            positions.bottomRight = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.bottomRight: "+positions.bottomRight);
		        });
		        
		        /* 
		        // FOR TESTS WITHOUT LEAP
				$("#touch-top-left").click(function(){
		            positions.topLeft = {
		                x : 0,    //Position au bout du premier doigt sur l'axe x
		                y : 0,
		                z : 0
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.topLeft: "+positions.topLeft);
		        });


		        $("#touch-top-right").click(function(){
		            positions.topRight = {
		                x : 2,
		                y : 0,
		                z : 0
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.topRight: "+positions.topRight);
		        });

		        $("#touch-bottom-left").click(function(){
			        positions.bottomLeft = {
		                x : 0,
		                y : -1,
		                z : 0
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.bottomLeft: "+positions.bottomLeft);
		        });


		        $("#touch-bottom-right").click(function(){
		            positions.bottomRight = {
		                x : 2,
		                y : -1,
		                z : 0
		            }
		            $(this).css('background-color','#eeeeee');
		            console.log("positions.bottomRight: "+positions.bottomRight);
		        });*/

		        $("#create-plane1").click(function(){
					$("#error").text("");
					$("#success").text("");

		        	try {
		        		if (positions.topLeft && positions.topRight && positions.bottomLeft && positions.bottomRight) {
				        	//Sauvegarde des positions dans positions1
				            positions1.topLeft = positions.topLeft;
				            positions1.topRight = positions.topRight;
				            positions1.bottomLeft = positions.bottomLeft;
				            positions1.bottomRight = positions.bottomRight;
		
				            //Création du plan 1
				            plane1 = createPlane(plane1,positions1);
		
				           	//sauvegarde de positions1
				            monobjet_json = JSON.stringify(positions1);
							localStorage.setItem("positions1",monobjet_json);
		
				            console.log("plane1: " + plane1);
				            
				            height_post_it = Math.abs(positions1.topLeft.y - positions1.bottomLeft.y);
				            width_post_it = Math.abs(positions1.topRight.x - positions1.topLeft.x);
				            
				            // Sauvegarde dans la bdd
				            $.ajax({
				                type: 'POST',
				                url: 'db/send_calib.php',
				                data: 'height_post_it=' + height_post_it + '&width_post_it=' + width_post_it + '&value=oui',
				                dataType: 'html', 
				                success: function(data) {
									$("#success").text("Calibration du bouton 'oui' réalisée avec succès");
									$("#error").text("");
				                },
				                error: function(data) {
					                $("#success").text("");
									$("#error").text(data);
				                }
				            });
			            } else {
				            $("#error").text("Veuillez sélectionner les quatre coins.");
			            }
		            }
		            catch (e) {
			            $("#error").text("Erreur dans la calibration du bouton oui : "+e.message);
			            $("#success").text("");
		            }
		            $("#touch-bottom-right").css('background-color','#ffffff');
		            $("#touch-top-right").css('background-color','#ffffff');
		            $("#touch-bottom-left").css('background-color','#ffffff');
		            $("#touch-top-left").css('background-color','#ffffff');
		            positions.topLeft = null;
		            positions.topRight = null;
		            positions.bottomLeft = null;
		            positions.bottomRight = null;
		        });

		        $("#create-plane2").click(function(){
		            
					$("#error").text("");
					$("#success").text("");
		            try {
		        		if (positions.topLeft && positions.topRight && positions.bottomLeft && positions.bottomRight) {
			            	positions2.topLeft = positions.topLeft;
				            positions2.topRight = positions.topRight;
				            positions2.bottomLeft = positions.bottomLeft;
				            positions2.bottomRight = positions.bottomRight;
		
				          	plane2 = createPlane(plane2,positions2);
		
				            //sauvegarde de positions2
				            monobjet_json = JSON.stringify(positions2);
							localStorage.setItem("positions2",monobjet_json);
							
				            console.log("plane2: " + plane2);
				            
				            height_post_it = Math.abs(positions1.topLeft.y - positions1.bottomLeft.y);
				            width_post_it = Math.abs(positions1.topRight.x - positions1.topLeft.x);
				            
				            // Sauvegarde dans la bdd
				            $.ajax({
				                type: 'POST',
				                url: 'db/send_calib.php',
				                data: 'height_post_it=' + height_post_it + '&width_post_it=' + width_post_it + '&value=non',
				                dataType: 'html', 
				                success: function(data) {
									$("#success").text("Calibration du bouton 'non' réalisée avec succès");
									$("#error").text("");
								},
				                error: function(data) {
					                $("#success").text("");
									$("#error").text(data);
				                }
				            });
			            } else {
				            $("#error").text("Veuillez sélectionner les quatre coins.");
			            }
		            }
		            catch (e) {
			            $("#error").text("Erreur dans la calibration du bouton non : "+e.message);
			            $("#success").text("");
		            }
		            $("#touch-bottom-right").css('background-color','#ffffff');
		            $("#touch-top-right").css('background-color','#ffffff');
		            $("#touch-bottom-left").css('background-color','#ffffff');
		            $("#touch-top-left").css('background-color','#ffffff');
		            positions.topLeft = null;
		            positions.topRight = null;
		            positions.bottomLeft = null;
		            positions.bottomRight = null;

		        });

		    }
		</script>

</body>

</html>
