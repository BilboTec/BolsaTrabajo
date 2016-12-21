<!DOCTYPE html>
<html ng-app="BilboTec" bt-lang="<?php echo (isset($lang)?$lang:"spanish"); ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/angular.min.js"></script>
	<script src="/js/angular-locale_<?php echo (isset($idioma)&&$idioma=="basque"?"eu":"es") ?>-es.js"></script>
	<script src="/js/angular-route.js"></script>
	<script src="/js/BilboTec.js"></script>
	<script src="/js/BilboTec.ui.js"></script>
	<?php echo csscrush_tag("/css/style.css"); ?>
	<!--<link rel="stylesheet" href="/css/style.css"/>-->
	<title><?php echo (isset($title)?$title:"Bolsa de Trabajo"); ?></title>
</head>
<body>
<header>
	<ul class="cabecera" >
		<?php if(isset($user)){
		
	}else{
		echo "<li class='usuario'>".strtoupper($idioma("usuario"))."</li>";
	} ?>
		
		<li class="idioma" ng-controller="idiomaController"><?php echo strtoupper($idioma("idioma")); ?>
			<ul>
				<li ng-click="cambiarIdioma('spanish')"><?php echo ucfirst($idioma("castellano")); ?></li>
				<li ng-click="cambiarIdioma('basque')">Euskera</li>
			</ul>
		</li>

	
	</ul>
</header>
