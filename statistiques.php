<!DOCTYPE html>
<html lang="en">


<?php include_once("head.php"); ?>

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
	?>
    
    <!-- Intro Section -->
    <section id="about" class="page-section">
        <div class="container">
            
            <div class="row">
            <div class="col-lg-12">
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
		  labels: ['Délai de réponse']
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
		  labels: ['Délai de réponse']
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
		  labels: ['Score']
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
		  labels: ['Score']
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
