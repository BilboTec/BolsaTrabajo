<div>
	<h1>{{usuario.nombre + " " + (usuario.apellido1 || "") + " " + (usuario.apellido2 || "")}}</h1>
	<p>{{email}}</p>
	<p>{{usuario.fecha_nacimiento}}</p>
	<p>{{usuario.dni}}</p>
	<p>{{usuario.calle + " " + usuario.cp + " " + localidad.nombre +"(" + provincia.nombre + ")"}}</p>
	<p>{{usuario.nacionalidad}}</p>
	<p>{{usuario.sexo==0?"<?php echo ucfirst($idioma("mujer")); ?>":"<?php echo ucfirst($idioma("hombre")); ?>"}}</p>
	<p>{{usuario.disponibilidad==0?"<?php echo ucfirst($idioma("no")); ?>":"<?php echo ucfirst($idioma("si")); ?>"}}</p>
	<div>{{usuario.otros_datos}}</div>

	<a class="btn btn-tipo sin-margen" href="#!/Editar">Editar</a>
	<a href="#!/Clave" class="btn btn-tipo">Cambiar Contraseña</a>
</div>