<div class="contenedor-invitar">
	<div>
		<h1><?php echo ucfirst($idioma("anadir_alumnos")); ?></h1>
		<div class="grupo-horizontal">
			<input type="text" ng-model="emails"/>
			<span class="btn btn-tipo" ng-click="cargarEmails()"><?php echo ucfirst($idioma("anadir")); ?></span>
		</div>
	</div>
	<div>
		<h1><?php echo ucfirst($idioma("cargar_csv")); ?></h1>
		<div bt-file-input="fileInput" ng-model="files" bt-accept=".csv"></div>
		<span class="btn btn-tipo" ng-click="cargarCSV()"><?php echo ucfirst($idioma("cargar")); ?></span>
	</div>
	<a href="#/!" class="btn btn-tipo"><?php echo ucfirst($idioma("volver")); ?></a>
	<div bt-window="ventana"></div>
</div>