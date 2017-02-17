<div class="contenedor-vertical todo contenedor-datos-personales">
	<h1><?php echo mb_strtoupper($idioma("datos_personales")); ?></h1>
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
	<div ng-repeat="experiencia in experiencias track by $index"">
		<p><h1>{{experiencia.empresa}}</h1><span>({{experiencia.fecha_inicio}} - {{experiencia.trabajando_actualmente=="1"?"<?php echo $idioma("actualmente"); ?>":experiencia.fecha_fin}})</span></p>
			<p>{{experiencia.cargo}}</p>
			<p bt-contenido-html ng-model="experiencia.funciones"></p>
	</div>
	<h1><?php echo mb_strtoupper($idioma("formacion_academica")); ?></h1>
	<div ng-repeat="formacion_academica in formaciones_academicas track by $index">
		<h1>{{formacion_academica.nombre}}</h1>
		<p>{{formacion_academica.fecha_inicio }} - {{formacion_academica.cursando?"En curso":formacion_academica.fecha_fin}}</p>
		<p>{{nombre_tipo_titulacion}}</p>
		<p>{{nombre_oferta_formativa}}</p>
		<div bt-contenido-html ng-model="formacion.descripcion"></div>
	</div>
	<h1><?php echo mb_strtoupper($idioma("formacion_complementaria")); ?></h1>
	<div ng-repeat="formacion_complementaria in formaciones_complementarias track by $index">
		<p><h1>{{formacion_complementaria.nombre}}</h1>
		{{formacion_complementaria.fecha_inicio }} - {{formacion_complementaria.cursando?"En curso":formacion_complementaria.fecha_fin}}</p>
		<p>{{formacion_complementaria.horas}}</p>
		<p>{{nombre_tipo_titulacion}}</p>
		<p>{{nombre_oferta_formativa}}</p>
		<div bt-contenido-html ng-model="formacion.descripcion"></div>
	</div>
	<h1><?php echo mb_strtoupper($idioma("idiomas")); ?></h1>
	<div ng-repeat="idioma in idiomas track by $index">
					<div class="grupo-horizontal">
						<p>{{idioma.nombre}} {{$parent.niveles[idioma.nivel - 1]}}
						</p>
					</div>
					<p ng-if="idioma.oficial==1"><?php echo ucfirst($idioma("oficial")); ?></p>
	</div>
	
	<h1><?php echo mb_strtoupper($idioma("otros_datos")); ?></h1>
	<div bt-contenido-html ng-model="alumno.otros_datos">
	</div>
	
	<div bt-notas-alumnos ng-model="alumno">
	</div>
	
	<a href="#/!" class="btn btn-tipo btn-con-margen"><?php echo ucfirst($idioma("volver")); ?></a>
</div>
