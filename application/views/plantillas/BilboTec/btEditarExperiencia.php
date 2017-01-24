<div ng-controller="btEditarExperiencia">

<div class="grupo">
	<label for="empresa"><?php echo ucfirst($idioma("empresa")); ?></label>
	<input type="text" ng-model="vista.empresa"/>
</div>

<div class="grupo">
	<label for="cargo"><?php echo ucfirst($idioma("cargo")); ?></label>
	<input type="text" ng-model="vista.cargo"/>
</div>

<div class="grupo">
	<label for="fecha_inicio"><?php echo ucfirst($idioma("fecha_inicio")); ?></label>
	<div bt-date-picker ng-model="vista.fecha_inicio"></div>
</div>

<div class="grupo" ng-show="!vista.trabajando_actualmente">
	<label for="fecha_fin"><?php echo ucfirst($idioma("fecha_fin")); ?></label>
	<div ng-disabled="vista.trabajando_actualmente" bt-date-picker ng-model="vista.fecha_fin"></div>
</div>

<div class="grupo">
	<label for="trabajando_actualmente"><input ng-change="onTrabajandoActualmente_change()" 
		type="checkbox" ng-model="vista.trabajando_actualmente"
		ng-true-value="1" ng-false-value="0" ng-checked="vista.trabajando_actualmente == 1"/><?php echo ucfirst($idioma("trabajando_actualmente")); ?></label>	
</div>

<div class="grupo">
	<label for="funciones"><?php echo ucfirst($idioma("funciones")); ?></label>
	<div bt-editor ng-model="vista.funciones"></div>
</div>
<button ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></button>
<button ng-click="cancelar()"><?php echo ucfirst($idioma("cancelar")); ?></button>
</div>