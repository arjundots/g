<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Game</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="js/jquery.html-svg-connect.js"></script>
  <script type="text/javascript">
   /*  jQuery(document).ready(function($) {
      $("#svgContainer").HTMLSVGconnect({
        stroke: "green",
        strokeWidth: 8,
        orientation: "auto",
        paths: [
          { start: "#29", end: "#78", strokeWidth: 12, orientation: "aotu"},
          { start: "#2", end: "#87", stroke: "red", }
        ]
      });  
    }); */
	function move_it(){
		$('#start').val();
		$('#end').val();
    }
jQuery(document).ready(function($) {
/*	A variable to keep track of where we are on the line
	0 = start, 1 = end */
var counter = 0;

/*	A boolean variable to keep track of the direction we want to travel in 
	true = move to the left, false move to the right */
var direction = true;

/*	First get a reference to the enclosing div and then to
	the 2 svg paths */
var svgContainer = document.getElementById("outerWrapper");
var ns = "http://www.w3.org/2000/svg";
var svg = svgContainer.getElementsByTagNameNS(ns, "path");
/*	the var 'svg' contains a reference to two paths so svg.length = 2
	svg[0] is the straight line and svg[1] is the curved lines */

/*	Now get the length of those two paths */
var straightLength = svg[0].getTotalLength();
var curveLength = svg[1].getTotalLength();

/*	Also get a reference to the two star polygons */
var stars = svgContainer.getElementsByTagName("polygon");

function moveStar() {
	/*	Check to see where the stars are journeys to determine 
		what direction they should be travelling in */
	if (parseInt(counter,10) === 1) {
		/* we've hit the end! */
		direction = false;
	} else if (parseInt(counter,10) < 0) {
		/* we're back at the start! */
		direction = true;
	}

	/*	Based on the direction variable either increase or decrease the counter */
	if (direction) {
		counter += 0.003;
	} else {
		counter -= 0.003;
	}

	/*	Now the magic part. We are able to call .getPointAtLength on the tow paths to return 
		the coordinates at any point along their lengths. We then simply set the stars to be positioned 
		at these coordinates, incrementing along the lengths of the paths */
	stars[0].setAttribute("transform","translate("+ (svg[0].getPointAtLength(counter * straightLength).x -15)  + "," + (svg[0].getPointAtLength(counter * straightLength).y -15) + ")");
	stars[1].setAttribute("transform","translate("+ (svg[1].getPointAtLength(counter * curveLength).x -15)  + "," + (svg[1].getPointAtLength(counter * curveLength).y -15) + ")");

	/*	Use requestAnimationFrame to recursively call moveStar() 60 times a second
		to create the illusion of movement */
	requestAnimationFrame(moveStar);
}
requestAnimationFrame(moveStar);
});
  </script>
	<style>		
		.row{width:800px;}
		.row > div {
		  background: #f1f6fb;
		  border: 1px solid grey;
		  width:10%;
		  height:70px;
		  text-align:center;
		  padding: 2px;
		}
		#svgContainer {		 
		  position: absolute;
		  opacity: 0.5;	
		}	
		
		
		
		.outerWrapper {
	width: 800px;
	height: 300px;
	position: relative;
}

.outerWrapper svg {
	position: absolute;
}

.outerWrapper svg path {
	fill:none; 
	stroke:#DABDD8;
	stroke-width:5; 
	stroke-dasharray:10,10;
}

.outerWrapper svg polygon {
	fill:orange; 
}
	</style>
  </head>
  <body>
	<?php require_once('Game.php'); ?>
    <header>
      <div>
        <h3>Snakes & Ladder</h3>
      </div>         
    </header>
<form name="pointform" method="post">
You pointed on start = <input type="text" id="start" /> - end = <input type="text" id="end" />
<input type="button" value="Move It" onclick="move_it();" />
</form> 



<div class="outerWrapper" id="outerWrapper">

	<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="100%" height="100%" viewBox="0 0 800 300" enable-background="new 0 0 800 300" xml:space="preserve">
		 
		<path d="M30,30 L770,30" />
		<path d="M29.833,113.5C29.833,178.667,99,271.334,257,271.334 S475.5,81,375.5,81S305,271.334,770,271.334"/>
		
		<polygon points="15,0 18.541,11.459 30,11.459 20.729,18.541 24.271,30 15,22.918 5.729,30 9.271,18.541 0,11.459 11.459,11.459"/>

		<polygon points="15,0 18.541,11.459 30,11.459 20.729,18.541 24.271,30 15,22.918 5.729,30 9.271,18.541 0,11.459 11.459,11.459"/>


	</svg>
       
</div>
</div>



    <!-- Page Content -->
  <div class="container">
	<div id="svgContainer"></div>
	<div class="row">
	<?php $class ='pull-right'; $counter=1; for($i=100;$i>0;$i--){  
		if($i%10==0){if($class=='pull-right'){$class='pull-left';}else{$class='pull-right';}}
		?>	
		<div id="<?=$i;?>" class="<?=$class; ?> box"><?php echo $i; ?></div>	
	<?php } ?>
	</div>
  </div>   
  </body>
</html>
