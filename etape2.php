<!DOCTYPE html>
<html lang="en">


<?php include_once("head.php"); ?>

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
                        <rect id ="rect1" width="200" height="200" fill="#F7230C" opacity="0.9"/>
                        <circle id="circle1" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="62" y="20" fill="black">Interface 1</text>
                    </svg>

                    <svg id="myCanvas2" width="200" height="200" background="green">
                        <rect id ="rect2" width="200" height="200" fill="#F7230C" opacity="0.9"/>
                        <circle id="circle2" cx="100" cy="100" r="8" stroke="black" stroke-width="3" fill="black" opacity="0.8"/>
                        <text x="62" y="20" fill="black">Interface 2</text>
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
    
    <form action="etape2_exercice.php" method="post">
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
    
	<script type="text/javascript">
	function next() {
		document.getElementById("pseudo").form.submit();
	}
	</script>
	
	    <!-- Leap Motion -->
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

            function touch_yes()
            {}
            function touch_no()
            {}
        </script>
</body>

</html>
