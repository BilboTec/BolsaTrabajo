<div ng-controller="btMostrarFormacionAcademica">
	<h1>{{formacion.nombre}}</h1>
	<p>{{formacion.fecha_inicio }} - {{formacion.cursando?"En curso":formacion.fecha_fin}}</p>
	<button ng-click="editar($index)"><?php echo ucfirst($idioma("editar")); ?></button>
	<button ng-click="borrar($index)"><?php echo ucfirst($idioma("eliminar")); ?></button>
	<p>{{nombre_tipo_titulacion}}</p>
	<p>{{nombre_oferta_formativa}}</p>
	<div bt-contenido-html ng-model="formacion.descripcion"></div>
</div>