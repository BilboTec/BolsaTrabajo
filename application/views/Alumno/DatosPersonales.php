<!--<div ng-controller="perfilAlumnoDatosPersonalesController">-->

<div class="contenedor-datos-personales">
	<div class="contenido_linea titulo-con-boton">
		<h1><?php echo strtoupper($idioma("datos_personales")); ?></h1>
		<span class="btn btn-tipo" ng-click="editar()" ng-show="!editando"><?php echo strtoupper($idioma("editar")); ?></span>
		<div class="grupo-botones">
			<a bg-show="!editando" class="btn btn-tipo btn-vertical" target="_blank" href="/api/Alumnos/Curriculum"><?php echo ucfirst($idioma("imprimir_curriculum")) ?></a>
			<span class="btn btn-tipo btn-vertical" ng-click="mostrarcambiarclave()" ng-show="editandoclave!=2"><?php echo mb_ucfirst($idioma('cambiar_clave')); ?></span>
			<span class="btn btn-tipo btn-vertical" ng-click="eliminarcuenta()" ng-show="!editando"><?php echo mb_ucfirst($idioma('eliminar_cuenta')); ?></span>
		</div>
	</div>
	
	<div ng-show="editandoclave === 2">
		<fieldset ng-controller="controladorClaveAlumno"  ng-form="formPerfil">
			<legend><?php echo strtoupper($idioma("cambiar_clave")); ?></legend>
			<div class="grupo">
				<div bt-input-label bt-id="clave" ng-required="true" name="clave" bt-label="'<?php echo ucfirst($idioma("clave_actual")); ?>'" bt-model="usuario.clave" type="password"></div>
				<div class="error_validacion" ng-show="(formPerfil.$submitted || formPerfil.clave.$touched) && formPerfil.clave.$invalid"><?php printf($idioma("required"),$idioma("clave_actual")); ?></div>
			</div>
			
			<div class="grupo">
				<div bt-input-label bt-id="nuevaclave" ng-required="true" name="nuevaclave" bt-label="'<?php echo ucfirst($idioma("clave_nueva")); ?>'" bt-model="usuario.nuevaclave" type="password"></div>
				<div class="error_validacion" ng-show="(formPerfil.$submitted || formPerfil.nuevaclave.$touched) && formPerfil.nuevaclave.$invalid"><?php printf($idioma("required"),$idioma("clave_nueva")); ?></div>
			</div>
			
			<div class="grupo">
				<div bt-input-label bt-id="repetirclave" ng-required="true" name="repetirclave" bt-label="'<?php echo ucfirst($idioma("repetir_clave")); ?>'" bt-model="usuario.repetirclave" type="password"></div>
				<div class="error_validacion" ng-show="(formPerfil.$submitted || formPerfil.repetirclave.$touched) && formPerfil.repetirclave.$invalid"><?php printf($idioma("required"),$idioma("repetir_clave")); ?></div>
			</div>
			
			<span class="btn btn-tipo" ng-click="cambiarClave()"><?php echo ucfirst($idioma("cambiar")); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar()" ng-show="editandoclave"><?php echo strtoupper($idioma("cancelar")); ?></span>
		
			<div bt-window="ventana"></div>
		</fieldset>
	</div>
	
	<div ng-show="!editando">
		<h1>{{ alumno.nombre }} {{ alumno.apellido1 }} {{ alumno.apellido2 }}</h1>
		<img src="{{imagen}}" ng-show="imagen"/>
		<p ng-show="alumno.fecha_nacimiento"><?php echo ucfirst($idioma("fecha_nacimiento")); ?>: {{ alumno.fecha_nacimiento }}</p>
		<p ng-show="alumno.dni"><?php echo ucfirst($idioma("dni")); ?>: {{ alumno.dni }}</p>
		<p ng-show="alumno.nacionalidad"><?php echo ucfirst($idioma("nacionalidad")); ?>: {{ alumno.nacionalidad }}</p>
		<p ng-show="alumno.tlf"><?php echo ucfirst($idioma("tlf")); ?>: {{ alumno.tlf }}</p>
		<p ng-show="alumno.calle"><?php echo ucfirst($idioma("calle"));?>: {{alumno.calle}} 
			<span ng-show="nombre_localidad">, {{nombre_localidad}}</span>
			<span ng-show="nombre_provincia">, {{nombre_provincia}}</span>
		</p>
	</div>
	
	
	<form id="formDatosPersonales" name="formDatosPersonales" ng-show="editando">
	<div>
		<div>
			<div class="grupo" bt-image-uploader ng-model="imagen_copia"></div>
		</div>
		
		<div>
			<div class="grupo">
				<label for="nombre"><?php echo ucfirst($idioma("nombre")) ?></label>
				<input type="text" id="nombre" ng-model="vista.nombre"/>
			</div>
			<div class="grupo">
				<label for="apellido1"><?php echo ucfirst($idioma("apellido1")); ?></label>
				<input type="text" id="apellido1" ng-model="vista.apellido1"/>
			</div>
			<div class="grupo">
				<label for="apellido2"><?php echo ucfirst($idioma("apellido2")); ?></label>
				<input type="text" id="apellido2" ng-model="vista.apellido2"/>
			</div>
			<div class="grupo">
				<label for="dni"><?php echo strtoupper($idioma("dni")); ?></label>
				<input type="text" id="dni" ng-model="vista.dni"/>
			</div>
		</div>
	</div>

	<div>
		<div>
			<div class="grupo">
				<label for="fecha_nacimiento"><?php echo ucfirst($idioma("fecha_nacimiento")); ?></label>
				<div bt-date-picker ng-model="vista.fecha_nacimiento"></div>
			</div>
			
			<div class="grupo">
				<label for="tlf"><?php echo ucfirst($idioma("tlf")); ?></label>
				<input type="tlf" id="tlf" ng-model="vista.tlf"/>
			</div>
			<div class="grupo">
				<label for="nacionalidad"><?php echo ucfirst($idioma("nacionalidad")); ?></label>
				<input type="text" id="nacionalidad" ng-model="vista.nacionalidad"/>
			</div>
		
			<div class="grupo">
				<label for="calle"><?php echo ucfirst($idioma("calle")); ?></label>
				<input type="text" id="calle" ng-model="vista.calle">
			</div>
			<div class="grupo">
				<label for="cp"><?php echo ucfirst($idioma("cp")); ?></label>
				<input type="text" id="cp" ng-model="vista.cp"/>
			</div>

			<div class="grupo">
				<label for="provincia"><?php echo ucfirst($idioma("provincia")); ?></label>
				<select name="id_provincia" id="provincia" ng-model="id_provincia" ng-change="cargarLocalidades()">
				<?php
					foreach ( $provincias as $provincia) {
						echo "<option value='" .$provincia->id_provincia ."'>" .$provincia->nombre ."</option>";
					}
				?>
				</select>
			</div>

			<div class="grupo">
				<label for="localidad"><?php echo ucfirst($idioma("localidad")); ?></label>
				<select name="id_localidad" id="localidad" ng-model="vista.id_localidad">
					<option ng-repeat="localidad in localidades" value="{{localidad.id_localidad}}">{{localidad.nombre}}</option>
				</select>
			</div>
		</div>
	</div>
	</form>
	<div>
		<span class="btn btn-tipo" ng-click="guardar()" ng-show="editando"><?php echo strtoupper($idioma("guardar")); ?></span>
		<span class="btn btn-tipo" ng-click="cancelar()" ng-show="editando"><?php echo strtoupper($idioma("cancelar")); ?></span>
	</div>
	<div bt-window="ventana"></div>
</div>
<!--</div>-->