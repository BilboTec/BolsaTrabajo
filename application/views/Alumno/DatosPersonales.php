<div ng-controller="perfilAlumnoDatosPersonalesController">
	<h1><?php echo strtoupper($idioma("datos_personales")); ?></h1>
	<div ng-show="!editando">
		<h1>{{ alumno.nombre }} {{ alumno.apellido1 }} {{ alumno.apellido2 }}</h1>
		<p ng-show="alumno.fecha_nacimiento"><?php echo ucfirst($idioma("fecha_nacimiento")); ?>: {{ alumno.fecha_nacimiento }}</p>
		<p ng-show="alumno.dni"><?php echo ucfirst($idioma("dni")); ?>: {{ alumno.dni }}</p>
		<p ng-show="alumno.nacionalidad"><?php echo ucfirst($idioma("nacionalidad")); ?>: {{ alumno.nacionalidad }}</p>
		<p ng-show="alumno.tlf"><?php echo ucfirst($idioma("tlf")); ?>: {{ alumno.tlf }}</p>
	</div>
	<form ng-show="editando">
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
			<label for="fecha_nacimiento">
			<div bt-date-picker ng-model="vista.fecha_nacimiento"></div>
		</div>
		<div class="grupo">
			<label for="dni"><?php echo strtopupper($idioma("dni")); ?></label>
			<input type="text" id="for" ng-model="vista.dni"/>
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
	</div>
</div>