<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Game</title>
	<!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js" ></script>
	<?php require_once('Game.php'); ?>
	<style>
		.container{float:left;width:100%;height:auto;}
		.lcell{width:8%;height:10%;float:left;border:1% solid #c4c4c4;text-align:center;}
		.rcell{width:8%;height:10%;float:right;border:1% solid #c4c4c4;text-align:center;}
		.box{padding:5%;  margin:5%;width:800px;height:800px;float:left;border:1px solid #c4c4c4;}
	</style>
  </head>

  <body>
    <header>
      <div>
        <h3>Snakes & Ladder</h3>
      </div>         
    </header>
    <!-- Page Content -->
  <div class="container">
	<div class="box">
	<?php $class ='rcell'; for($i=100;$i>0;$i--){  
		if($i%10==0){if($class=='rcell'){$class='lcell';}else{$class='rcell';}}
		?>	
		<div id="<?=$i;?>" class="<?=$class;?>"><?php echo $i; ?></div>	
	<?php } ?>
	</div>
  </div>    
  </body>
</html>
