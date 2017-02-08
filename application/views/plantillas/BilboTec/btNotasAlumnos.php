<div class="grupo-horizontal">
	<h1><?php echo mb_strtoupper($idioma("observaciones")); ?></h1>
	<span class="btn btn-tipo" ng-show="!insertando" ng-click="insertar()"> <?php echo mb_ucfirst($idioma("anadir")); ?></span>
</div>

<div ng-show="insertando">
	<div bt-editor ng-model="nueva_nota">
		
	</div>	
	<div class="grupo-horizontal">
		<span class="btn btn-tipo" ng-click="cancelar()"> <?php echo mb_ucfirst($idioma("cancelar")); ?></span>
		<span class="btn btn-tipo" ng-click="guardar()"> <?php echo mb_ucfirst($idioma("guardar")); ?></span>
	</div>
</div>

<div ng-repeat="nota in notas">
	<p>{{nota.profesor.nombre}} {{nota.profesor.apellido}} {{nota.profesor.apellido2}} ({{nota.fecha | btDate}})</p>
	<p bt-contenido-html ng-model="nota.nota"></p>
</div>
