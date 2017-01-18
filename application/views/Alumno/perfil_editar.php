<div class="grupo">
<h1 class="titulo"><?php echo strtoupper($idioma("editar_perfil")); ?></h1>
<div class="grupo">
	<label for="nombre"><?php echo ucfirst($idioma("nombre")); ?></label>
	<input id="nombre" ng-model="usuario.nombre"/>
</div>
<div class="grupo">
	<label for="apellido"><?php echo ucfirst($idioma("apellido1")); ?></label>
	<input id="apellido" ng-model="usuario.apellido1"/>
</div>

<div class="grupo">
	<label for="apellido2"><?php echo ucfirst($idioma("apellido2")); ?></label>
	<input id="apellido2" ng-model="usuario.apellido2"/>
</div>

<div class="grupo">
	<label for="fecha_nacimiento"><?php echo ucfirst($idioma("fecha_nacimiento")); ?></label>
	<input type="text" id="fecha_nacimiento" ng-model="usuario.fecha_nacimiento"/>
</div>

<div class="grupo">
	<label for="dni"><?php echo ucfirst($idioma("dni")); ?></label>
	<input type="text" id="dni" ng-model="usuario.dni"/>
</div>

<div class="grupo">
	<label for="calle"><?php echo ucfirst($idioma("calle")); ?></label>
	<input type="text" id="calle" ng-model="usuario.calle"/>
</div>

<div class="grupo">
	<label for="cp"><?php echo ucfirst($idioma("cp")); ?></label>
	<input type="text" id="cp" ng-model="usuario.cp"/>
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

<div class="grupo">
	<label for="nacionalidad"><?php echo ucfirst($idioma("nacionalidad")); ?></label>
	<input type="text" id="nacionalidad" ng-model="usuario.nacionalidad"/>
</div>

<div class="grupo">
<fieldset class="envoltura_controles">
	<legend><?php echo ucfirst($idioma("sexo")); ?></legend>

	<label for="sexo"><input type="radio" name="sexo" id="sexo" ng-model="usuario.sexo" value="0"/><?php echo ucfirst($idioma("mujer")); ?></label>
	<label for="sexo"><input type="radio" name="sexo" id="sexo" ng-model="usuario.sexo" value="1"/><?php echo ucfirst($idioma("hombre")); ?></label>
</fieldset>
</div>

<div class="grupo">
	<label for="disponobilidad"><input type="checkbox" name="disponibilidad" id="disponibilidad" ng-model="usuario.disponibilidad" value="0"/><?php echo ucfirst($idioma("disponibilidad")); ?></label>
</div>


<div class="grupo">
	<h2><?php echo ucfirst($idioma("otros_datos")); ?></h2>
	<div bt-editor="editor" ng-model="usuario.otros_datos"></div>
</div>

<div class="grupo">
	<div bt-experiencia ng-model="usuario"></div>
</div>

<div class="grupo">
	<div bt-formacion-academica ng-model="usuario"></div>
</div>
<div class="grupo">
	<div bt-formacion-complementaria ng-model="usuario"></div>
</div>
<div class="grupo">
	<div bt-idiomas ng-model="usuario"></div>
</div>
<span class="btn-tipo btn" ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></span>
<a href="#!/"><?php echo ucfirst($idioma("volver")); ?></a>
</div>