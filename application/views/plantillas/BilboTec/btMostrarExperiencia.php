<div class="experiencia" ng-controller="btMostrarExperiencia">
	<p><h1>{{experiencia.empresa}}</h1><span>({{experiencia.fecha_inicio}} - {{experiencia.trabajando_actualmente=="1"?"<?php echo $idioma("actualmente"); ?>":experiencia.fecha_fin}})</span></p>
	<p>{{experiencia.cargo}}</p>
	<p bt-contenido-html ng-model="experiencia.funciones"></p>
	<button ng-click="editar()"><?php echo ucfirst($idioma("editar")); ?></button>
	<button ng-click="borrar()"><?php echo ucfirst($idioma("eliminar")); ?></button>
</div>