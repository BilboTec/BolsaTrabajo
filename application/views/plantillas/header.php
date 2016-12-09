<!DOCTYPE html>
<html ng-app="BilboTec">
<head>
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/angular.min.js"></script>
	<script src="/js/BilboTec.js"></script>
	<script src="/js/BilboTec.ui.js"></script>
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
