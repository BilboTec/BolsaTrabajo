<div>
	<ul>
		<li ng-repeat="alumno in seleccionados">{{alumno.nombre}} <span class="btn btn-tipo" ng-click="deseleccionar($index)">&times;</span></li>
	</ul>
</div>
<div>
	<div>
		<div class="grupo">
			<label for="buscardor"><?php mb_ucfirst($idioma("buscador")); ?></label>
			<input type="text" id="buscador" name="buscador" ng-model="filtros.buscador"/>
		</div>
		<span class="btn btn-tipo" ng-click="buscar()">Buscar</span>
		<span class="btn btn-tipo" ng-click="guardar()">Guardar</span>
	</div>
	<ul>
		<li ng-repeat="alumno in vista">{{alumno.nombre}} <span class="btn btn-tipo" ng-click="seleccionar($index)">+</span></li>
	</ul>
</div>