<div>
	<h1>Añadir Alumnos</h1>
	<input type="text" ng-model="emails"/>
	<span ng-click="cargarEmails()">Cargar</span>
</div>
<div>
	<h1>Cargar CSV</h1>
	<input type="file" ng-model="csv"/>
	<span ng-click="cargarCSV()">Cargar</span>
</div>
<div bt-window="ventana"></div>