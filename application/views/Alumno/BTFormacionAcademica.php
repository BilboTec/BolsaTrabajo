<div class="contenedor-formacion-academica">
	<div class="grupo-horizontal space-between" ng-init='ofertas_formativas=<?php echo json_encode($ofertas_formativas); ?>;tipos_titulacion=<?php echo json_encode($tipos_titulacion); ?>'>
		<h1><?php echo mb_strtoupper($idioma("formacion_academica")); ?></h1>
		<span class="btn btn-tipo" ng-click="insertar()"><?php echo mb_ucfirst($idioma("anadir_formacion")); ?></span>
	</div>
	<div bt-window="ventana"></div>
	<div ng-form="ins" ng-if="insertando" ng-init="errores=false">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
				<input name="nombre" type="text" ng-required="true" ng-model="vista.nombre" id="nombre" />
				<span class="error_validacion" ng-if="formInsertar.nombre.$error.required">El campo nombre es obligatorio</span>
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div name="fecha_inicio" bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
				<span class="error_validacion" ng-if="formInsertar.fecha_inicio.$error.required">El campo fecha inicio es obligatorio</span>
				<span class="error_validacion" ng-if="formInsertar.fecha_inicio.$error.date">El campo fecha inicio ha de ser una fecha válida</span>
			</div>
			<div class="grupo">
				<label for="fecha_fin"><?php echo mb_ucfirst($idioma("fecha_fin")); ?></label>
				<div name="fecha_fin" bt-date-picker id="fecha_fin" ng-model="vista.fecha_fin"></div>
				<span class="error_validacion" ng-if="formInsertar.fecha_fin.$error.required">El campo fecha fin es obligatorio si la formación no se está cursando</span>
				<span class="error_validacion" ng-required="!vista.cursando" ng-if="formInsertar.fecha_fin.$error.date">El campo fecha fin ha de ser una fecha válida</span>
			</div>
			<div class="grupo">
				<label for="cursando"><input type="checkbox" ng-model="vista.cursando" ng-change="OnCursandoClick()" ng-true-value="1" ng-false-value="0"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
			</div>
		</div>
		<div class="grupo">
			<label for="tipo_titulacion"><?php echo mb_ucfirst($idioma("tipo_titulacion")); ?></label>
			<select ng-model="vista.id_tipo_titulacion" name="tipo_titulacion">
				<option value=''></option>
				<option ng-repeat="tipo in tipos_titulacion" value="{{tipo.id_tipo_titulacion}}">{{tipo.nombre}}</option>
			</select>
		</div>
		<div class="grupo">
			<label for="oferta_formativa"><?php echo mb_ucfirst($idioma("oferta_formativa")); ?></label>
			<select ng-model="vista.id_oferta_formativa" id="oferta_formativa">
				<option ng-repeat="oferta in ofertas_formativas | filter: {id_tipo_titulacion: vista.id_tipo_titulacion}" value="{{oferta.id_oferta_formativa}}">{{oferta.nombre}}</option>
			</select>
		</div>
	<div class="grupo">
			<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
			<div bt-editor ng-model="vista.descripcion"></div>
		</div>
		<div class="grupo">
			<label for="conocimientos"><?php echo mb_ucfirst($idioma("conocimientos")); ?></label>
			<div bt-auto-complete bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" bt-texto="nombre" ng-model="vista.conocimientos"></div>
		</div>
		<div class="grupo-horizontal">
			<span class="btn btn-tipo" ng-click="aplicarInsertar()"><?php echo mb_ucfirst($idioma("guardar")); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar()"><?php echo mb_ucfirst($idioma("cancelar")); ?></span>
		</div>
	</div>
	<div ng-repeat="formacion in formaciones | orderBy:'-fecha_fin'">
		<div ng-if="indiceEdicion !== $index" class="entrar-izq salir-der">
			<div class="grupo-horizontal space-between">
				<div class="grupo-horizontal">
					<h2>{{formacion.nombre}}</h2>
					<p>{{formacion.fecha_inicio | btDate}} - <span ng-if="formacion.cursando!='1'">{{formacion.fecha_fin | btDate}}</span>
					<span ng-if="formacion.cursando == '1'"><?php echo mb_ucfirst($idioma("cursando")); ?></span></p>
				</div>
				<div class="grupo-horizontal">
					<span title="<?php echo ucfirst($idioma("editar")); ?> ng-click="editar($index)" class="btn btn-tabla btn-editar" ng-if="indiceEdicion !== $index" ><img src="/imagenes/editar.png"/></span>
					<span title="<?php echo ucfirst($idioma("eliminar")); ?> ng-click="eliminar($index)" class="btn btn-tabla btn-eliminar" ng-if="indiceEdicion !== $index"><img src="/imagenes/eliminar.png"/></span>
				</div>
			</div>
			<p>{{nombre_tipo_titulacion}}</p>
			<p>{{nombre_oferta_formativa}}</p>
			<div ng-model="formacion.descripcion" bt-contenido-html></div>
			<p>Conocimientos:</p>
			<p ng-repeat="conocimiento in formacion.conocimientos">{{conocimiento.nombre}}</p>
		</div>
		<div ng-if="$parent.indiceEdicion === $index" ng-form="ins" class="entrar-izq salir-der">
			<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
				<input name="nombre" type="text" ng-required="true" ng-model="vista.nombre" id="nombre" />
				<span class="error_validacion" ng-if="formInsertar.nombre.$error.required">El campo nombre es obligatorio</span>
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div name="fecha_inicio" bt-date-picker id="fecha_inicio" ng-model="vista.fecha_inicio"></div>
				<span class="error_validacion" ng-if="formInsertar.fecha_inicio.$error.required">El campo fecha inicio es obligatorio</span>
				<span class="error_validacion" ng-if="formInsertar.fecha_inicio.$error.date">El campo fecha inicio ha de ser una fecha válida</span>
			</div>
			<div class="grupo">
				<label for="fecha_fin"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div name="fecha_fin" bt-date-picker id="fecha_fin" ng-model="vista.fecha_fin"></div>
				<span class="error_validacion" ng-if="formInsertar.fecha_fin.$error.required">El campo fecha fin es obligatorio si la formación no se está cursando</span>
				<span class="error_validacion" ng-required="!vista.cursando" ng-if="formInsertar.fecha_fin.$error.date">El campo fecha fin ha de ser una fecha válida</span>
			</div>
			<div class="grupo">
				<label for="cursando"><input type="checkbox" ng-model="vista.cursando" ng-change="OnCursandoClick()" ng-true-value="'1'" ng-false-value="'0'"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
			</div>
			</div>
			<div class="grupo">
				<label for="tipo_titulacion"><?php echo mb_ucfirst($idioma("tipo_titulacion")); ?></label>
				<select ng-model="vista.id_tipo_titulacion" name="tipo_titulacion">
					<option value=''></option>
					<option ng-repeat="tipo in tipos_titulacion" value="{{tipo.id_tipo_titulacion}}">{{tipo.nombre}}</option>
				</select>
			</div>
			<div class="grupo">
				<label for="oferta_formativa"><?php echo mb_ucfirst($idioma("oferta_formativa")); ?></label>
				<select ng-model="vista.id_oferta_formativa" id="oferta_formativa">
					<option ng-repeat="oferta in ofertas_formativas | filter: {id_tipo_titulacion: vista.id_tipo_titulacion}" value="{{oferta.id_oferta_formativa}}">{{oferta.nombre}}</option>
				</select>
			</div>
			<div class="grupo">
				<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
				<div bt-editor ng-model="vista.descripcion"></div>
			</div>
			<div class="grupo">
				<label for="conocimientos"><?php echo mb_ucfirst($idioma("conocimientos")); ?></label>
				<div bt-auto-complete bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" bt-texto="nombre" ng-model="vista.conocimientos"></div>
			</div>
			<div class="grupo-horizontal">
				<span class="btn btn-tipo" ng-click="aplicarEdicion()"><?php echo mb_ucfirst($idioma("guardar")); ?></span>
				<span class="btn btn-tipo" ng-click="cancelar()"><?php echo mb_ucfirst($idioma("cancelar")); ?></span>
			</div>
		</div>
	</div>
</div>