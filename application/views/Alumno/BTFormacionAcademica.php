

<div class="grupo-horizontal">
	<h1><?php echo uc_first($idioma("formacion_academica")); ?></h1>
	<span class="btn btn-tipo"><?php echo uc_first($idioma("formacion_nueva")); ?></span>
</div>
<div ng-if="insertando">
	<div class="grupo-horizontal">
		<div class="grupo">
			<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
			<input type="text" ng-model="$parent.vista.model" id="nombre" />
		</div>
		<div class="grupo">
			<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
			<div bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
		</div>
		<div class="grupo">
			<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
			<div bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
		</div>
	</div>
	<div class="grupo">
		<label for="cursando"><input type="ceckbox" ng-model="vista.cursando"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
	</div>
	<div class="grupo">
		<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
		<div bt-editor ng-model="vista.descripcion"></div>
	</div>
	<div class="grupo-horizontal">
		<span class="btn btn-tipo" ng-click="aplicarInsertar()"><?php echo uc_first($idioma("guardar")); ?></span>
		<span class="btn btn-tipo" ng-click="cancelar()"><?php echo uc_first($idioma("cancelar")); ?></span>
	</div>
</div>
<div ng-repeat="formacion in formaciones">
	<div ng-if="indiceEdicion !== $index">
		<div class="grupo-horizontal">
			<h2>{{formacion.nombre}}</h2>
			<p>{{formacion.fecha_inicio}} - <span ng-if="!formacion.cursando">{{formacion.fecha_inicio}}</span>
			<span ng-if="formacion.cursando"><?php echo mg_ucfirst($idioma("hasta_la_actualidad")); ?></span></p>
			<span ng-if="indiceEdicion !== $index" class="btn btn-tipo"><?php echo uc_first($idioma("editar")); ?></span>
		</div>
		<p>{{nombre_tipo_titulacion}}</p>
		<p>{{nombre_oferta_formativa}}</p>
		<div ng-model="formacion.descripcion" bt-contenido-html></div>
		<p>Conocimientos:</p>
		<p ng-repeat="conocimiento in conocimientos">{{conocimiento.nombre}}</p>
	</div>
	<div ng-if="$parent.indiceEdicion === $index">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
				<input type="text" ng-model="$parent.vista.model" id="nombre" />
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
			</div>
		</div>
		<div class="grupo">
			<label for="cursando"><input type="ceckbox" ng-model="vista.cursando"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
		</div>
		<div class="grupo">
			<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
			<div bt-editor ng-model="vista.descripcion"></div>
		</div>
		<div class="grupo-horizontal">
			<span class="btn btn-tipo" ng-click="aplicarActualizar()"><?php echo uc_first($idioma("guardar")); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar()"><?php echo uc_first($idioma("cancelar")); ?></span>
		</div>
	</div>
</div>