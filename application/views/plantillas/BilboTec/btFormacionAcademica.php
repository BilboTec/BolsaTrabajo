<div class="contenedor-formacion-academica">
	<div class="titulo-con-boton">
		<h1><?php echo mb_strtoupper($idioma("formacion_academica")); ?></h1>
		<button ng-click="insertar()"><?php echo ucfirst($idioma("anadir_formacion")); ?></button>
	</div>
	<div ng-init="nuevo=true" ng-show="insertando" ng-include="editar"></div>
	<div ng-model="formacion" ng-repeat="formacion in formaciones" ng-include="indiceEdicion == $index?editar:vista"></div>
</div>