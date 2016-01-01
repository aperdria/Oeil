<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projet Oeil</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/scrolling-nav.css">
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./css/flipclock.css">
    <link rel="stylesheet" href="css/style.css" >
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"

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
    
	<?php 
		include_once("db/functions_db.php");
		$bdd = connexion();
		$avg_delay_by_buttons_size = get_avg_delay_by_buttons_size($bdd);
		$avg_score_by_buttons_size = get_avg_score_by_buttons_size($bdd);
		$avg_delay_by_post_it_size = get_avg_delay_by_post_it_size($bdd);
		$avg_score_by_post_it_size = get_avg_score_by_post_it_size($bdd);
		$all_data = get_all_data($bdd);
	?>
    
    <!-- Intro Section -->
    <section id="about" class="stats-section">
        <div class="container">
            
            <div class="row stats">
            <div class="col-lg-12">
				<h2 class="cover-heading">Statistiques</h2>
                
            <div class="col-lg-12">
                <a id="export" onclick="exportData()" class="btn btn-default page-scroll" href="#">Exporter</a>
                <a class="btn btn-default page-scroll" href="statistiques.php?erase=true">Réinitialiser la base</a>
                </div>
				<div class="col-lg-6 col-md-6">
					<h4>Moyenne des délais de réponses par taille de boutons</h4>
                    <div id="avg_delay_by_buttons_size" style="height: 250px;"></div>
                </div>
				<div class="col-lg-6 col-md-6">
					<h4>Moyenne des délais de réponses par taille de post-it</h4>
                    <div id="avg_delay_by_post_it_size" style="height: 250px;"></div>
                </div></div>
            </div>
            <div class="row">
            <div class="col-lg-12">
				<div class="col-lg-6 col-md-6">
					<h4>Moyenne des scores par taille de boutons</h4>
                    <div id="avg_score_by_buttons_size" style="height: 250px;"></div>
                </div>
				<div class="col-lg-6 col-md-6">
					<h4>Moyenne des scores par taille de post-it</h4>
                    <div id="avg_score_by_post_it_size" style="height: 250px;"></div>
                </div></div>
            </div>
        </div>
    </section>
    
    <?php
    	function eraseData() {
			include_once "db/create_database.php";
			create_database(true, true);
    	}
    	
    	if(isset($_GET['erase'])) {
	    	eraseData();
    	}
    ?>
   
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>
    
    
    <script src="js/raphael-min.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/morris-data.js"></script>

	<script type="text/javascript">
	function exportData () {
		var stockData = <?php echo json_encode($all_data); ?>;
        var csv = convertArrayOfObjectsToCSV({data: stockData});
        csv = 'data:text/csv;charset=utf-8,' + csv;
		var encodedUri = encodeURI(csv);
		
		var expt = document.getElementById("export");
		expt.setAttribute("href", encodedUri);
		expt.setAttribute("download", "data.csv");
		expt.click();
	}
	
	function convertArrayOfObjectsToCSV(args) {  
	        var result, ctr, keys, columnDelimiter, lineDelimiter, data;
	
	        data = args.data || null;
	        if (data == null || !data.length) {
	            return null;
	        }
	
	        columnDelimiter = args.columnDelimiter || ';';
	        lineDelimiter = args.lineDelimiter || '\n';
	
	        keys = Object.keys(data[0]);
	
	        result = '';
	        result += keys.join(columnDelimiter);
	        result += lineDelimiter;
	
	        data.forEach(function(item) {
	            ctr = 0;
	            keys.forEach(function(key) {
	                if (ctr > 0) result += columnDelimiter;
	
	                result += item[key];
	                ctr++;
	            });
	            result += lineDelimiter;
	        });
	
	        return result;
	    }
	</script>

	<script type="text/javascript">
		Morris.Bar({
		  element: 'avg_delay_by_buttons_size',
		  data: [
				<?php 
					foreach ($avg_delay_by_buttons_size as $row) {
						$avg_delay = $row[0];
						$size = $row[1];
						echo '{ y: "'.$size.'", a: '.$avg_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Délai moyen']
		});
		
		Morris.Bar({
		  element: 'avg_delay_by_post_it_size',
		  data: [
				<?php 
					foreach ($avg_delay_by_post_it_size as $row) {
						$avg_delay = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "'.$height.'x'.$width.'", a: '.$avg_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Délai moyen'],
		  gridTextColor: '#47B3BC',
		  barColors: ['#47B3BC']
		});
		
				Morris.Bar({
		  element: 'avg_score_by_buttons_size',
		  data: [
				<?php 
					foreach ($avg_score_by_buttons_size as $row) {
						$avg_delay = $row[0];
						$size = $row[1];
						echo '{ y: "'.$size.'", a: '.$avg_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Score moyen'],
		  gridTextColor: '#A63B36',
		  barColors: ['#A63B36']
		});
		
		Morris.Bar({
		  element: 'avg_score_by_post_it_size',
		  data: [
				<?php 
					foreach ($avg_score_by_post_it_size as $row) {
						$avg_delay = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "'.$height.'x'.$width.'", a: '.$avg_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Score moyen'],
		  gridTextColor: '#BC5C4A',
		  barColors: ['#BC5C4A']
		});
	
		
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
