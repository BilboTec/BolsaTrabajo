<div class="contenedor-admin" ng-controller="administradorController">

<ul>
	<li ng-click= "establecerConfiguracion(configuraciones.conocimientos)"><?php echo ucfirst($idioma('conocimientos')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.departamentos)"><?php echo ucfirst($idioma('departamentos')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.tipo_titulacion)"><?php echo ucfirst($idioma('tipo_titulacion')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.oferta_formativa)"><?php echo ucfirst($idioma('oferta_formativa')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.conocimientos)"><?php echo ucfirst($idioma('localidades')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.provincias)"><?php echo ucfirst($idioma('provincias')); ?></li>
	<li ng-click= "establecerConfiguracion(configuraciones.pais)"><?php echo ucfirst($idioma('paises')); ?></li>
	
</ul>

	<div class="contenedor-tabla">
		<div bt-tabla ng-model="filas" bt-config="configuracion" bt-set-config="establecerConfiguracion"></div>
	</div>
</div>