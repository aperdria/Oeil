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
    <link href="css/morris.css" rel="stylesheet">

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
				<div class="col-lg-12 col-md-12">
					<h4>Pourcentage de réussite</h4>
                    <div id="global" style="height: 250px;"></div>
                </div>
				<div class="col-lg-12 col-md-12">
					<h4>Progression</h4>
                    <div id="progres" style="height: 250px;"></div>
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
    
    
    <script src="js/raphael-min.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/morris-data.js"></script>

    <!-- Leap Motion -->
    <script src="./js/three.js"></script>
	<script src="./js/leap.min.js"></script>
	<script type="text/javascript" src="./js/donnees_leap.js"></script>

	<script type="text/javascript">

		Morris.Bar({
		  element: 'progres',
		  data: [
				<?php 
					try {
						$db_handle = new PDO('sqlite:db.sqlite');
						$db_handle->type == 'sqlite';
						$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$req = $db_handle->prepare("SELECT AVG(score_tactile) as moy_score_tactile, AVG(score_gestuel) as moy_score_gestuel, date as date FROM scores GROUP BY strftime('%d', date) ORDER BY strftime('%d', date) DESC;");
						$req->execute();
						$result = $req->fetchAll();
						foreach ($result as $row) {
							$date = strftime('%d %b', strtotime($row[2]));
							echo '{ y: "'.$date.'", a: '.$row[0].', b: '.$row[1].' },';
						}
					} catch (Exception $e) {
						die('Erreur : '.$e->getMessage());
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a', 'b'],
		  labels: ['Tactile', 'Gestuel']
		});
	</script>

	<script type="text/javascript">
		Morris.Bar({
		  element: 'global',
		  data: [
		    <?php 
				try {
					$db_handle = new PDO('sqlite:db.sqlite');
					$db_handle->type == 'sqlite';
					$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$req = $db_handle->prepare("SELECT AVG(score_tactile) as moy_score_tactile, AVG(score_gestuel) as moy_score_gestuel FROM scores;");
					$req->execute();
					$result = $req->fetch();
						echo '{ y: "Comparaison", a: '.$row[0].', b: '.$row[1].' },';				} catch (Exception $e) {
					die('Erreur : '.$e->getMessage());
				}
			?>
		  ],
		  xkey: 'y',
		  ykeys: ['a', 'b'],
		  labels: ['Tactile', 'Gestuel']
		});
	</script>
	<script type="text/javascript">
	
		
		new Morris.Line({
		  // ID of the element in which to draw the chart.
		  element: 'chart2',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  data: [
		    { year: '2008', value: 20 },
		    { year: '2009', value: 10 },
		    { year: '2010', value: 5 },
		    { year: '2011', value: 5 },
		    { year: '2012', value: 20 }
		  ],
		  // The name of the data record attribute that contains x-values.
		  xkey: 'year',
		  // A list of names of data record attributes that contain y-values.
		  ykeys: ['value'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Value']
		});
	</script>

</body>

</html>
