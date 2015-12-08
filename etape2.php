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
            <div class="row" id="card">
				<div class="col-md-12">
						<h2 class="cover-heading">Etape 2</h2>
						<p>Nous allons passer à la deuxième étape.</br>Vous n'avez plus de boutons sur l'interface tactile, vous devez cliquer sur les post-it placés dans l'habitacle.</br> Vous pouvez vous entrainer à appuyer sur les post-it grâce à la visualisation ci-dessous. Quand vous êtes prêt, appuyez sur Continuer.</p>
						<a onclick="next()" class="btn btn-lg btn-default">Continuer</a>
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
    
    <form action="etape2_exercice.php" method="post">
		<input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>">
		<input type="hidden" name="hand" id="hand" value="<?php echo $_POST['hand'] ?>">
		<input type="hidden" name="score_tactile" id="score_tactile" value="<?php echo $_POST['score_tactile'] ?>">
	</form>
   
    <!-- jQuery -->
    <script src="./js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="./js/jquery.easing.min.js"></script>
    <script src="./js/scrolling-nav.js"></script>
    
	<script type="text/javascript">
	function next() {
		document.getElementById("pseudo").form.submit();
	}
	</script>
	
	    <!--Inclusion pour le Leap Motion-->
        <script src="./js/three.js"></script>
        <script src="./js/leap.min.js"></script>
        <script type="text/javascript" src="./js/donnees_leap.js"></script>

        <script>           
            //Gère les initialisations des boutons
            $(document).ready(function()
            {
                displayData = true;
                circle1 = $("#circle1");
                circle2 = $("#circle2");
                rect1 = $("#rect1");
                rect2 = $("#rect2");

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
</body>

</html>
