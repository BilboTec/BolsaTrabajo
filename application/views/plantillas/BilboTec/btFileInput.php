<div class="cuadro-archivos" ng-class="estado">
	<p ng-hide="files.length > 0"><?php echo mb_ucfirst($idioma("arrastre_archivo")); ?></p>
	<span ng-repeat="file in files">{{file.name}}</span>
</div>
<span class="btn btn-tipo" ng-click="abrirDialogo()">Abrir</span>