<!DOCTYPE html>
<html lang="en">

<?php include_once "head.php" ?>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


    <?php include_once "menu_min.php" ?>
    
	<?php 
		include_once("db/functions_db.php");
		$bdd = connexion();
		
		$avg_score_by_buttons_size = get_avg_score_by_buttons_size($bdd);
		$stddev_score_by_buttons_size = get_avg_score_by_buttons_size($bdd);
		
		$avg_score_by_post_it_size = get_avg_score_by_post_it_size($bdd);
		$stddev_score_by_post_it_size = get_avg_score_by_post_it_size($bdd);
		
		$avg_delay_by_buttons_size = get_avg_delay_by_buttons_size($bdd);
		$min_max_delay_by_buttons_size = get_min_max_delay_by_buttons_size($bdd);
		$stddev_delay_by_buttons_size = get_avg_delay_by_buttons_size($bdd);
		
		$avg_delay_by_post_it_size = get_avg_delay_by_post_it_size($bdd);
		$min_max_delay_by_post_it_size = get_min_max_delay_by_post_it_size($bdd);
		$stddev_delay_by_post_it_size = get_avg_delay_by_post_it_size($bdd);
		
		
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
            </div>
            
            <div class="row" style="padding-top:50px;">
	            <div class="col-lg-12">
						<h4>Moyenne des scores par taille de boutons et de post-it</h4>
	                    <div id="avg_score" style="height: 250px;"></div>
	            </div>
            </div>
            <div class="row" style="padding-top:50px;">
	            <div class="col-lg-12">
						<h4>Ecart type des scores par taille de boutons et de post-it</h4>
	                    <div id="stddev_score" style="height: 250px;"></div>
	            </div>
            </div>
            <div class="row">
	            <div class="col-lg-12" style="padding-top:50px;">
						<h4>Moyenne des délais de réponses par taille de boutons et de post-it</h4>
	                    <div id="avg_delay" style="height: 250px;"></div>
	            </div>
            </div>
            <div class="row">
	            <div class="col-lg-12" style="padding-top:50px;">
						<h4>Ecart type des délais de réponses par taille de boutons et de post-it</h4>
	                    <div id="stddev_delay" style="height: 250px;"></div>
	            </div>
            </div>
            <div class="row">
	            <div class="col-lg-12" style="padding-top:50px;">
						<h4>Min et max des délais de réponses par taille de boutons et de post-it</h4>
	                    <div id="min_max_delay" style="height: 250px;"></div>
	            </div>
            </div>
        </div>
    </section>
    
    <?php
    	function eraseData() {
			include_once "db/create_database.php";
			create_database(true, true);
			header('Location:index.php');
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
		  element: 'avg_delay',
		  data: [
				<?php 
					foreach ($avg_delay_by_buttons_size as $row) {
						$avg_delay = $row[0];
						$size = $row[1];
						echo '{ y: "Bouton '.$size.'", a: '.$avg_delay.'},';
					}
					foreach ($avg_delay_by_post_it_size as $row) {
						$avg_delay = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "Post-it '.$height.'x'.$width.'", a: '.$avg_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Délai moyen'],
		  barColors: function (row, series, type) {
			console.log("--> "+row.label, series, type);
			if(row.label.substring(0, 6) == "Bouton") return "#335DA6";
				else return "#47B3BC";
			}
		});
		Morris.Bar({
		  element: 'stddev_delay',
		  data: [
				<?php 
					foreach ($stddev_delay_by_buttons_size as $row) {
						$stddev_delay = $row[0];
						$size = $row[1];
						echo '{ y: "Bouton '.$size.'", a: '.$stddev_delay.'},';
					}
					foreach ($stddev_delay_by_post_it_size as $row) {
						$stddev_delay = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "Post-it '.$height.'x'.$width.'", a: '.$stddev_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Délai moyen'],
		  barColors: function (row, series, type) {
			console.log("--> "+row.label, series, type);
			if(row.label.substring(0, 6) == "Bouton") return "#335DA6";
				else return "#47B3BC";
			}
		});
		Morris.Bar({
		  element: 'min_max_delay',
		  data: [
				<?php 
					foreach ($min_max_delay_by_buttons_size as $row) {
						$min_delay = $row[0];
						$max_delay = $row[1];
						$size = $row[2];
						echo '{ y: "Bouton '.$size.'", a: '.$min_delay.', b: '.$max_delay.'},';
					}
					foreach ($min_max_delay_by_post_it_size as $row) {
						$min_delay = $row[0];
						$max_delay = $row[1];
						$height = $row[2];
						$width = $row[3];
						echo '{ y: "Post-it '.$height.'x'.$width.'", a: '.$min_delay.', b: '.$max_delay.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a','b'],
		  labels: ['Délai moyen'],
		  barColors: function (row, series, type) {
			console.log("--> "+row.label, series, type);
			if(row.label.substring(0, 6) == "Bouton") return "#335DA6";
				else return "#47B3BC";
			}
		});

		Morris.Bar({
		  element: 'avg_score',
		  data: [
				<?php 
					foreach ($avg_score_by_buttons_size as $row) {
						$avg_score = $row[0];
						$size = $row[1];
						echo '{ y: "Bouton '.$size.'", a: '.$avg_score.'},';
					}
					foreach ($avg_score_by_post_it_size as $row) {
						$avg_score = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "Post-it '.$height.'x'.$width.'", a: '.$avg_score.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Score moyen'],
		  barColors: function (row, series, type) {
			console.log("--> "+row.label, series, type);
			if(row.label.substring(0, 6) == "Bouton") return "#A63B36";
				else return "#BE6B5D";
			}
		});
		Morris.Bar({
		  element: 'stddev_score',
		  data: [
				<?php 
					foreach ($stddev_score_by_buttons_size as $row) {
						$stddev_score = $row[0];
						$size = $row[1];
						echo '{ y: "Bouton '.$size.'", a: '.$stddev_score.'},';
					}
					foreach ($stddev_score_by_post_it_size as $row) {
						$stddev_score = $row[0];
						$height = $row[1];
						$width = $row[2];
						echo '{ y: "Post-it '.$height.'x'.$width.'", a: '.$stddev_score.'},';
					}
				?>
		  ],
		  xkey: 'y',
		  ykeys: ['a'],
		  labels: ['Score moyen'],
		  barColors: function (row, series, type) {
			console.log("--> "+row.label, series, type);
			if(row.label.substring(0, 6) == "Bouton") return "#A63B36";
				else return "#BE6B5D";
			}
		});
	
	
		/*
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
		});*/
	</script>

</body>

</html>
