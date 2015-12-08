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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

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
    <section id="about" class="page-section">
        <div class="container">
            <div class="row">
				<div class="col-md-12">
						<h2 class="cover-heading">Calibrage de l'espace de capture</h2>
					<p class="lead">Pour chaque angle de la future interface, positionner votre index puis cliquer sur le bouton correspondant. Une fois les quatre angles créés appuyer sur le bouton "Créer l'interface tactile". A refaire pour les deux interfaces que l'on souhaite créer.</p>
					<a href="#" class="btn btn-lg btn-default" id="touch-top-left" style="width:150px">Top Left</a>
      				<a href="#" class="btn btn-lg btn-default" id="touch-top-right" style="width:150px">Top Right</a>
      				<br>
      				<a href="#" class="btn btn-lg btn-default" id="touch-bottom-left" style="width:150px">Bottom Left</a>
      				<a href="#" class="btn btn-lg btn-default" id="touch-bottom-right" style="width:150px">Bottom Right</a>
      				<br><br>
      				<a href="#" class="btn btn-lg btn-default" id="create-plane1">Interface 1</a>
      				<a href="#" class="btn btn-lg btn-default" id="create-plane2">Interface 2</a>
				</div>
				 
				 
				<div class="col-md-12"></br>
                    <svg id="myCanvas" width="200" height="200" background="green">
                        <rect id ="rect1" width="200" height="200" fill="#4BB3D6" opacity="0.9"/>
                        <circle id="circle1" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="62" y="20" fill="black">Interface 1</text>
                    </svg>

                    <svg id="myCanvas2" width="200" height="200" background="green">
                        <rect id ="rect2" width="200" height="200" fill="#7AD678" opacity="0.9"/>
                        <circle id="circle2" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="62" y="20" fill="black">Interface 2</text>
                    </svg>
                </div>
                        
				<div class="col-md-12">
                    <div class="col-md-3">
                        <h4><b>Interface</b></h4>
                        <div id="frameData"></div>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="col-md-3">
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

		<script>

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
		            console.log("positions.topLeft: "+positions.topLeft);
		        });


		        $("#touch-top-right").click(function(){
		            positions.topRight = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            console.log("positions.topRight: "+positions.topRight);
		        });

		        $("#touch-bottom-left").click(function(){
			        positions.bottomLeft = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            console.log("positions.bottomLeft: "+positions.bottomLeft);
		        });


		        $("#touch-bottom-right").click(function(){
		            positions.bottomRight = {
		                x : globalFrame.pointables[0].stabilizedTipPosition[0],
		                y : globalFrame.pointables[0].stabilizedTipPosition[1],
		                z : globalFrame.pointables[0].stabilizedTipPosition[2]
		            }
		            console.log("positions.bottomRight: "+positions.bottomRight);
		        });

		        $("#create-plane1").click(function(){
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
		        });

		        $("#create-plane2").click(function(){
		            positions2.topLeft = positions.topLeft;
		            positions2.topRight = positions.topRight;
		            positions2.bottomLeft = positions.bottomLeft;
		            positions2  .bottomRight = positions.bottomRight;

		          	plane2 = createPlane(plane2,positions2);

		            //sauvegarde de positions2
		            monobjet_json = JSON.stringify(positions2);
					localStorage.setItem("positions2",monobjet_json);
					
		            console.log("plane2: " + plane2);
		        });

		    }
		</script>

</body>

</html>
