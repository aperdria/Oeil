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
    <section id="about" class="about-section">
        <div class="container">
            <div class="row" id="card">
				<div class="col-md-12">
					<h2 class="cover-heading">Etape 1</h2>
					<p class="lead">Bienvenue sur l'outil de test du projet Interaction.</br>Vous aurez dix secondes pour répondre aux questions qui vont vous être posées.</br>Entrez votre pseudo et appuyez sur commencer.</p>
					<form action="etape1_exercice.php" method="POST">
						<input type="text" placeholder="Votre pseudo" name="pseudo">
						<span class="help-block"></span>
						<p>Avec quelle main tapez-vous sur l'écran ?</p>
						<div class="radio">
						  <label><input type="radio" name="hand" value="left">Gauche</label>
						  <label><input type="radio" name="hand" value="right">Droite</label>
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

</body>

</html>
