<div class="contenedor-formacion-complementaria">
	<div class="titulo-con-boton">
		<h1><?php echo strtoupper($idioma("formacion_complementaria")); ?></h1>
		<button ng-click="insertar()"><?php echo ucfirst($idioma("anadir_formacion")); ?></button>
	</div>
	<div  ng-show="insertando" ng-include="editar"></div>
	<div ng-model="formacion" ng-repeat="formacion in formaciones track by $index" ng-include="indiceEdicion == $index?editar:vista"></div>
</div>