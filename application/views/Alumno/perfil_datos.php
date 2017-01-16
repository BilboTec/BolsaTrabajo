<div>
	<h1>{{usuario.nombre + " " + (usuario.apellido1 || "") + " " + (usuario.apellido2 || "")}}</h1>
	<p>{{email}}</p>
	<p ng-show="usuario.fecha_nacimiento">{{usuario.fecha_nacimiento}}</p>
	<p ng-show="usuario.dni">{{usuario.dni}}</p>
	<p ng-show="usuario.calle || usuario.cp || localidad.nombre || provincia.nombre">{{usuario.calle + " " + usuario.cp + " " + localidad.nombre +"(" + provincia.nombre + ")"}}</p>
	<p ng-show="usuario.nacionalidad">{{usuario.nacionalidad}}</p>
	<p ng-show="usuario.sexo">{{usuario.sexo==0?"<?php echo ucfirst($idioma("mujer")); ?>":"<?php echo ucfirst($idioma("hombre")); ?>"}}</p>
	<p ng-show="usuario.disponibilidad">{{usuario.disponibilidad==0?"<?php echo ucfirst($idioma("no")); ?>":"<?php echo ucfirst($idioma("si")); ?>"}}</p>
	<div ng-show="usuario.otros_datos">{{usuario.otros_datos}}</div>

	<a class="btn btn-tipo sin-margen" href="#!/Editar">Editar</a>
	<a href="#!/Clave" class="btn btn-tipo">Cambiar Contraseña</a>
</div>