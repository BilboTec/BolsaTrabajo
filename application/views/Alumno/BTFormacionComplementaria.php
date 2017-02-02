<form name="formComplementaria" ng-init='ofertas_formativas=<?php echo json_encode($ofertas_formativas); ?>;tipos_titulacion=<?php echo json_encode($tipos_titulacion); ?>'>
<div bt-window="ventana"></div>
	<div class="grupo-horizontal space-between">
			<h1><?php echo mb_strtoupper($idioma("formacion_complementaria")); ?></h1>
			<span class="btn btn-tipo" ng-click="insertar()"><?php echo mb_ucfirst($idioma("anadir_formacion")); ?></span>
	</div>
	<div class="animacion-cortina" ng-if="insertando">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
				<input type="text" ng-model="vista.nombre" ng-required="true"/>
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_inicio"></div>
			</div>
			<div class="grupo" ng-hide="vista.cursando == 1">
				<label for="fecha_fin"><?php echo mb_ucfirst($idioma("fecha_fin")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_fin"></div>
			</div>
			<div class="grupo">
				<label for="cursando"><input type="checkbox" name="cursando" id="cursando" ng-model="vista.cursando" ng-true-value="'1'" ng-false-value="'0'"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
			</div>
		</div>
		<div class="grupo">
				<label for="horas"><?php echo mb_ucfirst($idioma("horas")); ?></label>
				<input type="number" ng-model="vista.horas" name="horas">
		</div>
		<div class="grupo">
			<label for="tipo_titulacion"><?php echo mb_ucfirst($idioma("tipo_titulacion")); ?></label>
			<select ng-model="vista.id_tipo_titulacion" name="tipo_titulacion" id="tipo_titulacion">
				<option ng-repeat="tipo_titulacion in tipos_titulacion" value="{{tipo_titulacion.id_tipo_titulacion}}">{{tipo_titulacion.nombre}}</option>
			</select>
		</div>
		<div class="grupo">
			<label for="oferta_formativa"><?php echo mb_ucfirst($idioma("oferta_formativa")); ?></label>
			<select id="oferta_formativa" name="oferta_formativa" ng-model="vista.id_oferta_formativa">
				<option ng-repeat="oferta_formativa in ofertas_formativas | filter:{id_tipo_titulacion:vista.id_tipo_titulacion}" value="{{oferta_formativa.id_oferta_formativa}}">{{oferta_formativa.nombre}}</option>
			</select>
		</div>
		<div class="grupo">
			<label for="conocimientos"><?php echo mb_ucfirst($idioma("conocimientos")); ?></label>
			<div bt-auto-complete="autoComplete" bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" ng-model="vista.conocimientos" bt-texto="nombre"></div>
		</div>
		<div class="grupo">
				<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
				<div name="descripcion" id="descripcion" bt-editor="editor" ng-model="vista.descripcion"></div>
		</div>
		<div class="grupo-horizontal">
			<span class="btn btn-tipo" ng-click="aplicarInsertar()">Guardar</span>
			<span class="btn btn-tipo" ng-click="cancelar()">Cancelar</span>
		</div>
	</div>
	<div ng-repeat="formacion_complementaria in formaciones">
		<div ng-if="indiceEdicion != $index">
			<div class="grupo-horizontal space-between">
				<div class="grupo-horizontal">
					<h1>{{formacion_complementaria.nombre}}</h1>
					<p>{{formacion_complementaria.fecha_inicio}}</p>
					<p>-</p>
					<p ng-if="formacion_complementaria.cursando == '1'"><?php echo mb_ucfirst($idioma("cursando")); ?></p>
					<p ng-if="formacion_complementaria.cursando != '1'">{{formacion_complementaria.fecha_fin}}</p>
				</div>
				<div class="grupo-horizontal">		
					<span class="btn btn-tipo" ng-click="editar($index)"><?php echo ucfirst($idioma("editar")); ?></span>
					<span class="btn btn-tipo" ng-click="eliminar($index)"><?php echo ucfirst($idioma("eliminar")); ?></span>
				</div>
			</div>
			<p>{{nomrbesTiposTitulacion[oferta.id_tipo_titulacion]}}</p>
			<P>{{formacion.complementaria.horas}}
			<div bt-contenido-html ng-model="formacion_complementaria.descripcion"></div>
			<h3>Conocimientos</h3>
			<p ng-repeat="conocimiento in formacion_complementaria.conocimientos">{{conocimiento.nombre}}</p>
		</div>
		<div class="entrar-izq salir-der" ng-if="indiceEdicion == $index">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="nombre"><?php echo mb_ucfirst($idioma("nombre")); ?></label>
				<input type="text" ng-model="vista.nombre" ng-required="true"/>
			</div>
			<div class="grupo">
				<label for="fecha_inicio"><?php echo mb_ucfirst($idioma("fecha_inicio")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_inicio"></div>
			</div>
			<div class="grupo" ng-hide="vista.cursando == '1'">
				<label for="fecha_fin"><?php echo mb_ucfirst($idioma("fecha_fin")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_fin"></div>
			</div>
			<div class="grupo">
				<label for="cursando"><input type="checkbox" name="cursando" id="cursando" ng-model="vista.cursando" ng-true-value="'1'" ng-false-value="'0'"/><?php echo mb_ucfirst($idioma("cursando")); ?></label>
			</div>
		</div>
		<div class="grupo">
				<label for="horas"><?php echo mb_ucfirst($idioma("horas")); ?></label>
				<input type="number" ng-model="vista.horas" name="horas">
		</div>
		<div class="grupo">
			<label for="tipo_titulacion"><?php echo mb_ucfirst($idioma("tipo_titulacion")); ?></label>
			<select ng-model="vista.id_tipo_titulacion" name="tipo_titulacion" id="tipo_titulacion">
				<option ng-repeat="tipo_titulacion in tipos_titulacion" value="{{tipo_titulacion.id_tipo_titulacion}}">{{tipo_titulacion.nombre}}</option>
			</select>
		</div>
		<div class="grupo">
			<label for="oferta_formativa"><?php echo mb_ucfirst($idioma("oferta_formativa")); ?></label>
			<select id="oferta_formativa" name="oferta_formativa" ng-model="vista.id_oferta_formativa">
				<option ng-repeat="oferta_formativa in ofertas_formativas | filter:{id_tipo_titulacion:vista.id_tipo_titulacion}" value="{{oferta_formativa.id_oferta_formativa}}">{{oferta_formativa.nombre}}</option>
			</select>
		</div>
		<div class="grupo">
			<label for="conocimientos"><?php echo mb_ucfirst($idioma("conocimientos")); ?></label>
			<div bt-auto-complete="autoComplete" bt-url="/api/Conocimientos/Like" bt-clave="id_conocimiento" bt-texto="nombre" ng-model="vista.conocimientos"></div>
		</div>
		<div class="grupo">
				<label for="descripcion"><?php echo mb_ucfirst($idioma("descripcion")); ?></label>
				<div name="descripcion" id="descripcion" bt-editor="editor" ng-model="vista.descripcion"></div>
		</div>
		<div class="grupo-horizontal">
			<span class="btn btn-tipo" ng-click="aplicarEdicion()">Guardar</span>
			<span class="btn btn-tipo" ng-click="cancelar()">Cancelar</span>
		</div>
	</div>
	</div>
</form>