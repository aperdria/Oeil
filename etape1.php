<!DOCTYPE html>
<html lang="en">

<?php
	// Check if calibrage has been done, otherwise redirects to config
	include_once("db/functions_db.php");
	$bdd = connexion();
	$calibrage_post_it_is_done = is_calibrage_post_it_done($bdd);
	$calibrage_buttons_is_done = is_calibrage_buttons_done($bdd);
	
	$calibrage_post_it_is_done = true;
	$calibrage_buttons_is_done = true;
	
	if($calibrage_buttons_is_done && $calibrage_post_it_is_done)
		include_once("head.php");
	else
		echo '<head><meta http-equiv="refresh" content="0;URL=config.php"></head>';
?>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    
    <?php include_once "menu_min.php" ?>

    <!-- Intro Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row" id="card">
				<div class="col-md-12">
					<h2 class="cover-heading">Etape 1</h2>
					<p class="lead">Bienvenue sur l'outil de test du projet Interaction.</br>Vous aurez dix secondes pour répondre aux questions qui vont vous être posées.</br>Entrez votre pseudo et appuyez sur commencer.</p>
					<form action="etape1_exercice.php" method="POST" name="form" onsubmit="return checkForm()">
						<textarea id="write" rows="1" placeholder="Votre pseudo" name="pseudo"></textarea>
						<span class="help-block"></span>
						<p>Avec quelle main tapez-vous sur l'écran ?</p>
						<div class="radio">
						  <label><input type="radio" name="hand" value="left">Gauche</label>
						  <label><input type="radio" name="hand" value="right" checked>Droite</label>
						</div>
						<button type="submit" class="btn btn-default">Commencer</button>
						<div id="error"></div>
					</form>
				 </div>
				 <div class="col-md-12">
				 <div id="container-keyboard">
				    <ul id="keyboard">
				        <li class="symbol"><span class="off">`</span><span class="on">~</span></li>
				        <li class="symbol"><span class="off">1</span><span class="on">!</span></li>
				        <li class="symbol"><span class="off">2</span><span class="on">@</span></li>
				        <li class="symbol"><span class="off">3</span><span class="on">#</span></li>
				        <li class="symbol"><span class="off">4</span><span class="on">$</span></li>
				        <li class="symbol"><span class="off">5</span><span class="on">%</span></li>
				        <li class="symbol"><span class="off">6</span><span class="on">^</span></li>
				        <li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
				        <li class="symbol"><span class="off">8</span><span class="on">*</span></li>
				        <li class="symbol"><span class="off">9</span><span class="on">(</span></li>
				        <li class="symbol"><span class="off">0</span><span class="on">)</span></li>
				        <li class="symbol"><span class="off">-</span><span class="on">_</span></li>
				        <li class="symbol"><span class="off">=</span><span class="on">+</span></li>
				        <li class="delete lastitem">delete</li>
				        <li class="tab">tab</li>
				        <li class="letter">q</li>
				        <li class="letter">w</li>
				        <li class="letter">e</li>
				        <li class="letter">r</li>
				        <li class="letter">t</li>
				        <li class="letter">y</li>
				        <li class="letter">u</li>
				        <li class="letter">i</li>
				        <li class="letter">o</li>
				        <li class="letter">p</li>
				        <li class="symbol"><span class="off">[</span><span class="on">{</span></li>
				        <li class="symbol"><span class="off">]</span><span class="on">}</span></li>
				        <li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
				        <li class="capslock">caps lock</li>
				        <li class="letter">a</li>
				        <li class="letter">s</li>
				        <li class="letter">d</li>
				        <li class="letter">f</li>
				        <li class="letter">g</li>
				        <li class="letter">h</li>
				        <li class="letter">j</li>
				        <li class="letter">k</li>
				        <li class="letter">l</li>
				        <li class="symbol"><span class="off">;</span><span class="on">:</span></li>
				        <li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
				        <li class="return lastitem">return</li>
				        <li class="left-shift">shift</li>
				        <li class="letter">z</li>
				        <li class="letter">x</li>
				        <li class="letter">c</li>
				        <li class="letter">v</li>
				        <li class="letter">b</li>
				        <li class="letter">n</li>
				        <li class="letter">m</li>
				        <li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
				        <li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
				        <li class="symbol"><span class="off">/</span><span class="on">?</span></li>
				        <li class="right-shift lastitem">shift</li>
				        <li class="space lastitem">&nbsp;</li>
				    </ul>
				</div>
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

	<script type="text/javascript">
	function checkForm () {
		if(document.form.pseudo.value == "") {
			document.getElementById("error").innerHTML = '<p style="color:red; padding-top:10px;">Vous devez entrer un pseudo valide.</p>';
			return false;
		}
		else {
			return true;
		}
	};
	</script>
	
	<script>
		$(function(){
		    var $write = $('#write'),s
		        shift = false,
		        capslock = false;
		     
		    $('#keyboard li').click(function(){
		        var $this = $(this),
		            character = $this.html(); // If it's a lowercase letter, nothing happens to this variable
		         
		        // Shift keys
		        if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
		            $('.letter').toggleClass('uppercase');
		            $('.symbol span').toggle();
		             
		            shift = (shift === true) ? false : true;
		            capslock = false;
		            return false;
		        }
		         
		        // Caps lock
		        if ($this.hasClass('capslock')) {
		            $('.letter').toggleClass('uppercase');
		            capslock = true;
		            return false;
		        }
		         
		        // Delete
		        if ($this.hasClass('delete')) {
		            var html = $write.html();
		             
		            $write.html(html.substr(0, html.length - 1));
		            return false;
		        }
		         
		        // Special characters
		        if ($this.hasClass('symbol')) character = $('span:visible', $this).html();
		        if ($this.hasClass('space')) character = ' ';
		        if ($this.hasClass('tab')) character = "\t";
		        if ($this.hasClass('return')) character = "\n";
		         
		        // Uppercase letter
		        if ($this.hasClass('uppercase')) character = character.toUpperCase();
		         
		        // Remove shift once a key is clicked.
		        if (shift === true) {
		            $('.symbol span').toggle();
		            if (capslock === false) $('.letter').toggleClass('uppercase');
		             
		            shift = false;
		        }
		         
		        // Add the character
		        $write.html($write.html() + character);
		    });
		});
	</script>

</body>

</html>
