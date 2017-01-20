<div ng-controller="perfilAlumnoDatosPersonalesController">
	<div class="contenido_linea">
		<h1><?php echo strtoupper($idioma("datos_personales")); ?></h1>
		<button ng-click="editar()" ng-show="!editando"><?php echo strtoupper($idioma("editar")); ?></button>
	</div>
	<div ng-show="!editando">
		<h1>{{ alumno.nombre }} {{ alumno.apellido1 }} {{ alumno.apellido2 }}</h1>
		<img src="{{imagen}}" ng-show="imagen"/>
		<p ng-show="alumno.fecha_nacimiento"><?php echo ucfirst($idioma("fecha_nacimiento")); ?>: {{ alumno.fecha_nacimiento }}</p>
		<p ng-show="alumno.dni"><?php echo ucfirst($idioma("dni")); ?>: {{ alumno.dni }}</p>
		<p ng-show="alumno.nacionalidad"><?php echo ucfirst($idioma("nacionalidad")); ?>: {{ alumno.nacionalidad }}</p>
		<p ng-show="alumno.tlf"><?php echo ucfirst($idioma("tlf")); ?>: {{ alumno.tlf }}</p>
		<p ng-show="alumno.calle"><?php echo ucfirst("calle");?>{{alumno.calle}} </p>
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
				<input type="text" id="for" ng-model="vista.dni"/>
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
				<select name="id_localidad" id="localidad" ng-model="usuario.id_localidad">
					<option ng-repeat="localidad in localidades" value="{{localidad.id_localidad}}">{{localidad.nombre}}</option>
				</select>
			</div>
		</div>
	</div>
	</form>
	<div>
		<button ng-click="guardar()" ng-show="editando"><?php echo strtoupper($idioma("guardar")); ?></button>
		<button ng-click="cancelar()" ng-show="editando"><?php echo strtoupper($idioma("cancelar")); ?></button>
	</div>
</div>