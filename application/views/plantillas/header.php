<!DOCTYPE html>
<html ng-app="BolsaTrabajo">
<head>
	<script src="/Bolsa_Trabajo/Bolsa_Trabajo/js/jquery-3.1.1.min.js"></script>
	<script src="/Bolsa_Trabajo/Bolsa_Trabajo/js/angular.min.js"></script>
	<script src="/Bolsa_Trabajo/Bolsa_Trabajo/js/BolsaTrabajo.js"></script>
	<link rel="stylesheet" href="/Bolsa_Trabajo/Bolsa_Trabajo/css/style.css"/>
	<title><?php echo (isset($title)?$title:"Bolsa de Trabajo"); ?></title>
</head>
<body>
<header>
	<ul>
		<li>Idioma
			<ul>
				<li>Castellano</li>
				<li>Euskera</li>
			</ul>
		</li>
	</ul>
	<?php if(isset($user)){
		
	}else{
		
	} ?>
</header>
