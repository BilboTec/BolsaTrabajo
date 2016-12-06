<!DOCTYPE html>
<html ng-app="BolsaTrabajo">
<head>
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/angular.min.js"></script>
	<script src="/js/BolsaTrabajo.js"></script>
	<script src="/js/BolsaTrabajo.ui.js"></script>
	<link rel="stylesheet" href="/css/style.css"/>
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
