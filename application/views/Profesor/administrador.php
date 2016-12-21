<div class="contenedor-admin" ng-controller="administradorController">

<ul class="lista_cambios">
	<li class= "btn-cambio" ng-class="seleccionado==0?'activo':''" ng-click= "establecerConfiguracion(configuraciones.conocimientos); seleccionado=0"><?php echo ucfirst($idioma('conocimientos')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==1?'activo':''" ng-click= "establecerConfiguracion(configuraciones.departamentos); seleccionado=1"><?php echo ucfirst($idioma('departamentos')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==2?'activo':''" ng-click= "establecerConfiguracion(configuraciones.tipo_titulacion); seleccionado=2"><?php echo ucfirst($idioma('tipo_titulacion')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==3?'activo':''" ng-click= "establecerConfiguracion(configuraciones.oferta_formativa); seleccionado=3"><?php echo ucfirst($idioma('oferta_formativa')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==4?'activo':''" ng-click= "establecerConfiguracion(configuraciones.pais); seleccionado=4"><?php echo ucfirst($idioma('paises')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==5?'activo':''" ng-click= "establecerConfiguracion(configuraciones.provincias); seleccionado=5"><?php echo ucfirst($idioma('provincias')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==6?'activo':''" ng-click= "establecerConfiguracion(configuraciones.localidades); seleccionado=6"><?php echo ucfirst($idioma('localidades')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==7?'activo':''" ng-click= "establecerConfiguracion(configuraciones.profesores); seleccionado=7"><?php echo ucfirst($idioma('profesores')); ?></li>
	
	
</ul>

	<div class="contenedor-tabla">
		<div bt-tabla ng-model="filas" bt-config="configuracion" bt-set-config="establecerConfiguracion"></div>
	</div>
</div>