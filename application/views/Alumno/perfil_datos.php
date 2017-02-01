<!--<div>
	<div class="grupo-horizontal">
		<h1>{{usuario.nombre + " " + (usuario.apellido1 || "") + " " + (usuario.apellido2 || "")}}</h1>
		<a class="btn btn-tipo" href="/api/Alumnos/Curriculum">Imprimir curriculum</a>
	</div>
	<p>{{email}}</p>
	<p ng-show="usuario.fecha_nacimiento">{{usuario.fecha_nacimiento}}</p>
	<p ng-show="usuario.dni">{{usuario.dni}}</p>
	<p ng-show="usuario.calle || usuario.cp || localidad.nombre || provincia.nombre">{{usuario.calle + " " + usuario.cp + " " + localidad.nombre +"(" + provincia.nombre + ")"}}</p>
	<p ng-show="usuario.nacionalidad">{{usuario.nacionalidad}}</p>
	<p ng-show="usuario.sexo">{{usuario.sexo==0?"<?php echo ucfirst($idioma("mujer")); ?>":"<?php echo ucfirst($idioma("hombre")); ?>"}}</p>
	<p ng-show="usuario.disponibilidad">{{usuario.disponibilidad==0?"<?php echo ucfirst($idioma("no")); ?>":"<?php echo ucfirst($idioma("si")); ?>"}}</p>
	<div bt-contenido-html ng-model="usuario.otros_datos"></div>

	<a class="btn btn-tipo sin-margen" href="#!/Editar">Editar</a>
	<a href="#!/Clave" class="btn btn-tipo">Cambiar Contraseña</a>
</div>-->