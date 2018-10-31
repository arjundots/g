<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Game</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<script src="js/jquery.html-svg-connect.js"></script>
		<?php require_once('Game.php'); ?>
		<?php list($snakes,$ladders) = new_game(); ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				snakes = {};
				ladders = {};
				var paths = [];
				<?php foreach($snakes as $key => $val){ ?>
					snakes[<?=$val?>]  = <?=$key?>;
					var path = {start: "#<?=$key?>", end: "#<?=$val?>", stroke: "red", class: "snake", strokeWidth: 3 };
					paths.push(path);
				<?php } ?>
				<?php foreach($ladders as $key => $val){ ?>
					ladders[<?=$key?>]  = <?=$val?>;
					paths.push({start: "#<?=$key?>", end: "#<?=$val?>", stroke: "green", class: "ladder", strokeWidth: 12 });
				<?php } ?>
				
				$("#svgContainer").HTMLSVGconnect({
					orientation: "auto",
					paths: paths
				});
				
				
				// New game
				var players = $('#p1,#p2').detach();
				players.appendTo('#1');
				$('#player1').addClass('turn');
				var deg_temp =0;
				var player_turn = 1;
				// Dice
				jQuery("#dice").click(function(){		 
					deg_temp = deg_temp+90;
					$(this).css({'transform': 'rotate('+deg_temp+'deg)'});
					
					$('#pmv'+player_turn).html(Math.floor((Math.random() * 6) + 1));
					$('#player'+player_turn).removeClass('turn');
					move_it(player_turn);
					if(player_turn == 1){
						player_turn = 2;
					}else{
						player_turn = 1;
					}
					$('#pmv'+player_turn).html('');
					$('#player'+player_turn).addClass('turn');
				});				
			});
			 
			function move_it(player_turn){
				var move_no    = $('#pmv'+player_turn).html();
				var currentPos = $('#p'+player_turn).parent().attr('id');
				
				var newPos = Number(currentPos)+Number(move_no);
				if(newPos<=100){
					if(ladders.hasOwnProperty(newPos)){
						alert('You are on ladder.');
						newPos = ladders[newPos];
					}
					if(snakes.hasOwnProperty(newPos)){
						alert('You are on snake.');
						newPos = snakes[newPos];
					}
					var palyer = $('#p'+player_turn).detach();				
					palyer.appendTo('#'+newPos);
					$('#'+currentPos).removeClass('active');
					$('#'+newPos).addClass('active');
					
					check_position(newPos,player_turn);
				}
			}
			function check_position(newPos,player_turn){
				
				if(newPos==100){
					$('#'+newPos).css({'background':'lightgreen'});
					$("#dice").remove();
					$('#msg').html('Congratulations !! Player '+player_turn+' has been won.');
				}
			}
		</script>
		<style>		
			.row{width:80%;float:left;}
			.row > div {
				background: transparent;
				border: 1px solid grey;
				width:10%;
				height:70px;
				text-align:center;
				padding: 2px;
				float:left;
			}
			#svgContainer {		 
				position: absolute;
				opacity: 0.8;
				z-index: -1;
			}
			.ladder{
				stroke-dasharray:2,5;
			}
			.snake{
				/* stroke-dasharray:1,3; */
			}
			.turn{
				font-weight:bold;
				color: green;
			}
			.active{
				border-color: cyan !important;				
			}
			#msg{
				font-weight:bold;
				color: green;
			}
			.panel{
				width:20%;
				float:right;
				text-align:center;
			}
			.panel > table{
				margin:10px;					
			}
			.panel > table td,th {
				height: 50px;
				width: 50%;
				padding: 5px;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<header>
			<div>
				<h3>Snakes & Ladder</h3>
				<h2 id="msg"></h2>
			</div>         
		</header>
		<div class="container">
			<img id="p1" src="icon/p1.png"/>
			<img id="p2" src="icon/p2.png"/>
			<div id="svgContainer"></div>	
			<div class="row">
				<?php $class ='pull-right'; $counter=1; for($i=100;$i>0;$i--){  
					if($i%10==0){if($class=='pull-right'){$class='pull-left';}else{$class='pull-right';}}
				?>	
				<div id="<?=$i;?>" class="<?=$class; ?> box"><?php echo $i; ?></div>	
				<?php } ?>
			</div>
			<div class="panel">
			<table align="center" border="1" cellspacing='1'>
				<tr>
					<th><h4 id="player1">Player 1<h4/></th>
					<th><h4 id="player2">Player 2<h4/></th>
				</tr>
				<tr>
					<td><h4 id="pmv1"></h4></td>
					<td><h4 id="pmv2"></h4></td>
				</tr>
				<tr>
					<td colspan="2"><img id="dice" src="icon/dice.png"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="button" value="New Game" onclick="javascript:window.location.reload();" /></td>
				</tr>
			</table>
			<?php foreach($snakes as $key => $val){
				echo "<p style='color:red'>snake start:- $val end:- $key</p>";
			}
			foreach($ladders as $key => $val){ 
				echo "<p style='color:green'>ladder start:- $key end:- $val</p>";
			} ?>
			</div>
		</div>
	</body>
</html>
		