<div class="contenedor-otros-datos" ng-controller="perfilAlumnoOtrosDatosController">
	<div class="titulo-con-boton">
		<h1><?php echo strtoupper($idioma("otros_datos")); ?></h1>
		<span class="btn btn-tipo" ng-click="editar()" ng-show="!editando"><?php echo strtoupper($idioma("editar")); ?></span>
	</div>	
	<div bt-contenido-html ng-model="alumno.otros_datos" ng-show="!editando"></div>
	<div bt-editor ng-model="vista.otros_datos" ng-show="editando">	</div>
	<div>
		<span class="btn btn-tipo" ng-click="guardar()" ng-show="editando"><?php echo strtoupper($idioma("guardar")); ?></span>
		<span class="btn btn-tipo" ng-click="cancelar()" ng-show="editando"><?php echo strtoupper($idioma("cancelar")); ?></span>
	</div>
</div>