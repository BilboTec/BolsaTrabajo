<div ng-controller="administradorController">

<ul>
	<li ng-click= "configuracion = configuraciones.conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></li>
	<li ng-click= "configuracion = configuraciones.departamentos"><?php echo ucfirst($idioma('departamentos')); ?></li>
	<li ng-click= "configuracion = configuraciones.tipo_titulacion"><?php echo ucfirst($idioma('tipo_titulacion')); ?></li>
	<li ng-click= "configuracion = configuraciones.conocimientos"><?php echo ucfirst($idioma('oferta_formativa')); ?></li>
	<li ng-click= "configuracion = configuraciones.conocimientos"><?php echo ucfirst($idioma('localidades')); ?></li>
	<li ng-click= "configuracion = configuraciones.conocimientos"><?php echo ucfirst($idioma('provincias')); ?></li>
	<li ng-click= "configuracion = configuraciones.conocimientos"><?php echo ucfirst($idioma('paises')); ?></li>
</ul>


	<div bt-tabla ng-model="filas" bt-config="configuracion"></div>
</div>