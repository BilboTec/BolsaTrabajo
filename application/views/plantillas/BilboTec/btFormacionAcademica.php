<div class="contenedor-formacion-academica">
	<div class="titulo-con-boton">
		<h1><?php echo mb_strtoupper($idioma("formacion_academica")); ?></h1>
		<button ng-click="insertar()"><?php echo ucfirst($idioma("anadir_formacion")); ?></button>
	</div>
	<div ng-if="insertando">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idoma("nombre")); ?></label>
				<input id="nombre" type="text" ng-model="vista.nombre">
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div id="fecha_inicio" bt-date-picker="fechaInicio" ng-model="vista.fecha_inicio"></div>
			</div>
			<div class="grupo">
				<label for="fecha_fin"><?php echo mb_ucfirst($idioma("fecha_fin")); ?></label>
				<div id="fecha_fin" bt-date-picker="fechaFin" ng-model="vista.fecha_fin"></div>
			</div>
		</div>
		<div class="grupo">
		<label for="cursando"><input type="checkbox" id="cursando" ng-true-value="1" ng-false-value="0" ng-model="cursando"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
		</div>
		<div class="grupo">
			<label for="tipo_titulacion"><?php echo mb_ucfirst($idioma("tipo_titulacion")); ?></label>
			<select id="tipo_titulacion" ng-model="tipo_titulacion">
				<option ng-repeat
			</select>
		</div>
	</div>
	<div ng-init="nuevo=true" ng-show="insertando" ng-include="editar"></div>
	<div ng-model="formacion" ng-repeat="formacion in formaciones" ng-include="indiceEdicion == $index?editar:vista"></div>
</div>