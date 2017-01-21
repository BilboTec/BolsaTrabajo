<div class="cuadro-archivos" ng-class="estado">
	<span ng-repeat="file in files">{{file.name}}</span>
</div>
<span class="btn btn-tipo" ng-click="abrirDialogo()">Abrir</span>