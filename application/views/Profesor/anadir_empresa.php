 <div class="contenedor-anadir-empresa">
	<div>
		<h1><?php echo ucfirst($idioma("anadir_empresa")); ?></h1>
		<div class="grupo-horizontal">
			<label>Nombre</label>
			<input type="text"/>
			
			<label>Sector</label>
			<input type="text"/>
			
			<label>CIF</label>
			<input type="text"/>
			
			<label>Pais</label>
			<input type="text"/>
			
			<label>Localidad</label>
			<input type="text"/>
			
			
			<a class="btn btn-tipo" ng-click="anadirEmpresa()"><?php echo ucfirst($idioma("anadir")); ?></a>
		</div>
	</div>
	<a href="#/!" class="btn btn-tipo"><?php echo ucfirst($idioma("volver")); ?></a>
	<div bt-window="ventana"></div>
</div>
