<!DOCTYPE html>
<html ng-app="BilboTec">
<head>
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/angular.min.js"></script>
	<script src="/js/angular-locale_<?php echo (isset($idioma)&&$idioma=="basque"?"eu":"es") ?>-es.js"></script>
	<script src="/js/BilboTec.js"></script>
	<script src="/js/BilboTec.ui.js"></script>
	<link rel="stylesheet" href="/css/style.css"/>
	<title><?php echo (isset($title)?$title:"Bolsa de Trabajo"); ?></title>
</head>
<body>
<header>
	<ul class="idioma" ng-controller="idiomaController">
		<li><?php echo ucfirst($idioma("idioma")); ?>
			<ul>
				<li ng-click="cambiarIdioma('spanish')"><?php echo ucfirst($idioma("castellano")); ?></li>
				<li ng-click="cambiarIdioma('basque')">Euskera</li>
			</ul>
		</li>
	</ul>
	<?php if(isset($user)){
		
	}else{
		echo "<span>".ucfirst($idioma("usuario"))."</span>";
	} ?>
</header>
