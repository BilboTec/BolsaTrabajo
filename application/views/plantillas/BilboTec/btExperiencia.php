<div class="contenedor-experiencia">
	<div class="titulo-con-boton">
		<h1><?php echo strtoupper($idioma("experiencia")); ?></h1>
		<span class="btn btn-tipo" ng-if="!insertando" ng-click="insertar($event)"><?php echo ucfirst($idioma("anadir_experiencia")); ?></span>
	</div>
	<div ng-if="insertando" class="animacion-cortina">
		<div class="grupo">
			<label for="empresa"><?php echo ucfirst($idioma("empresa")); ?></label>
			<input type="text" ng-model="vista.empresa"/>
		</div>
	
		<div class="grupo">
			<label for="cargo"><?php echo ucfirst($idioma("cargo")); ?></label>
			<input type="text" ng-model="vista.cargo"/>
		</div>
	
		<div class="grupo">
			<label for="fecha_inicio"><?php echo ucfirst($idioma("fecha_inicio")); ?></label>
			<div bt-date-picker ng-model="vista.fecha_inicio"></div>
		</div>
	
		<div class="grupo" ng-show="!vista.trabajando_actualmente">
			<label for="fecha_fin"><?php echo ucfirst($idioma("fecha_fin")); ?></label>
			<div ng-disabled="vista.trabajando_actualmente" bt-date-picker ng-model="vista.fecha_fin"></div>
		</div>
	
		<div class="grupo">
			<label for="trabajando_actualmente"><input ng-change="onTrabajandoActualmente_change()" 
				type="checkbox" ng-model="vista.trabajando_actualmente"
				ng-true-value="1" ng-false-value="0" ng-checked="vista.trabajando_actualmente == 1"/><?php echo ucfirst($idioma("trabajando_actualmente")); ?></label>	
		</div>
		<div class="grupo">
			<label for="funciones"><?php echo ucfirst($idioma("funciones")); ?></label>
			<div bt-editor ng-model="vista.funciones"></div>
		</div>
		
		<div class="grupo">
			<label for="conocimientos"><?php echo ucfirst($idioma("conocimientos")); ?></label>
			<div bt-auto-complete bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" bt-texto="nombre" ng-model="vista.conocimientos"></div>
		</div>
		
		<span class="btn btn-tipo" ng-click="aplicarInsertar()"><?php echo ucfirst($idioma("guardar")); ?></span>
		<span class="btn btn-tipo" ng-click="cancelar()"><?php echo ucfirst($idioma("cancelar")); ?></span>
	</div>
	<div ng-repeat="experiencia in experiencias | orderBy: '-fecha_fin'">
		<div ng-if="indiceEdicion == $index">
			<div class="grupo">
				<label for="empresa"><?php echo ucfirst($idioma("empresa")); ?></label>
				<input type="text" ng-model="vista.empresa"/>
			</div>
	
			<div class="grupo">
				<label for="cargo"><?php echo ucfirst($idioma("cargo")); ?></label>
				<input type="text" ng-model="vista.cargo"/>
			</div>
	
			<div class="grupo">
				<label for="fecha_inicio"><?php echo ucfirst($idioma("fecha_inicio")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_inicio"></div>
			</div>
	
			<div class="grupo" ng-show="!vista.trabajando_actualmente">
				<label for="fecha_fin"><?php echo ucfirst($idioma("fecha_fin")); ?></label>
				<div ng-disabled="vista.trabajando_actualmente" bt-date-picker ng-model="vista.fecha_fin"></div>
			</div>
	
			<div class="grupo">
				<label for="trabajando_actualmente"><input ng-change="onTrabajandoActualmente_change()" 
					type="checkbox" ng-model="vista.trabajando_actualmente"
					ng-true-value="1" ng-false-value="0" ng-checked="vista.trabajando_actualmente == 1"/><?php echo ucfirst($idioma("trabajando_actualmente")); ?></label>	
			</div>
	
			<div class="grupo">
				<label for="funciones"><?php echo ucfirst($idioma("funciones")); ?></label>
				<div bt-editor ng-model="vista.funciones"></div>
			</div>
			
			<div class="grupo">
				<label for="conocimientos"><?php echo ucfirst($idioma("conocimientos")); ?></label>
				<div bt-auto-complete bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" bt-texto="nombre" ng-model="vista.conocimientos"></div>
			</div>
			<span class="btn btn-tipo" ng-click="aplicarEdicion($event,$index)"><?php echo strtoupper($idioma("guardar")); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar($event)"><?php echo strtoupper($idioma("cancelar")); ?></span>
		</div>
		<div class="experiencia" ng-if="indiceEdicion != $index">
			<div class="grupo-horizontal space-between">
				<div class="grupo-horizontal">
					<p><h1>{{experiencia.empresa}}</h1><span>({{experiencia.fecha_inicio}} - {{experiencia.trabajando_actualmente=="1"?"<?php echo $idioma("actualmente"); ?>":experiencia.fecha_fin}})</span></p>
					<p>{{experiencia.cargo}}</p>
					<p bt-contenido-html ng-model="experiencia.funciones"></p>
					<p ng-repeat="conocimiento in experiencia.conocimientos">{{conocimiento.nombre}}</p>
				</div>
				<div class="grupo-horizontal">
					<span title="<?php echo ucfirst($idioma("editar")); ?>" class="btn btn-tabla btn-editar" ng-click="editar($event,$index)"><img src="/imagenes/editar.png"/></span>
					<span title="<?php echo ucfirst($idioma("eliminar")); ?>" class="btn btn-tabla btn-eliminar" ng-click="borrar($event,$index)"><img src="/imagenes/eliminar.png"/></span>
				</div>
			</div>
		</div>
	</div>
	<div bt-window="ventana"></div>
</div>
