<!DOCTYPE html>
<html ng-app="BilboTec">
<head>
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/angular.min.js"></script>
	<script src="/js/angular-locale_<?php echo (isset($idioma)&&$idioma=="basque"?"eu":"es") ?>-es.js"></script>
	<script src="/js/BilboTec.js"></script>
	<script src="/js/BilboTec.ui.js"></script>
	<?php echo csscrush_tag("/css/style.css"); ?>
	<!--<link rel="stylesheet" href="/css/style.css"/>-->
	<title><?php echo (isset($title)?$title:"Bolsa de Trabajo"); ?></title>
</head>
<body>
<header>
	<ul class="idioma" >
		<li ng-controller="idiomaController"><?php echo ucfirst($idioma("idioma")); ?>
			<ul>
				<li ng-click="cambiarIdioma('spanish')"><?php echo ucfirst($idioma("castellano")); ?></li>
				<li ng-click="cambiarIdioma('basque')">Euskera</li>
			</ul>
		</li>

	<?php if(isset($user)){
		
	}else{
		echo "<li class='usuario'>".ucfirst($idioma("usuario"))."</li>";
	} ?>
	</ul>
</header>
