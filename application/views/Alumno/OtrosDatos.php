<div ng-controller="perfilAlumnoOtrosDatosController">
	<h1><?php echo strtoupper($idioma("otros_datos")); ?></h1>
	<button ng-click="editar()" ng-show="!editando"><?php echo strtoupper($idioma("editar")); ?></button>	<div bt-contenido-html ng-model="alumno.otros_datos" ng-show="!editando"></div>
	<div bt-editor ng-model="vista.otros_datos" ng-show="editando">	</div>
	<div>
		<button ng-click="guardar()" ng-show="editando"><?php echo strtoupper($idioma("guardar")); ?></button>
		<button ng-click="cancelar()" ng-show="editando"><?php echo strtoupper($idioma("cancelar")); ?></button>
	</div>
</div>