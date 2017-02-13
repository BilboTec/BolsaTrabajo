<div class="buscardor-alumno">
	<div>
		<h3>Apuntar alumnos a esta oferta</h3>
		<ul>
			<li ng-repeat="alumno in seleccionados"><span>{{alumno.nombre}}</span> <span class="btn" ng-click="deseleccionar($index)"><img src="/imagenes/eliminar.png"/></span></li>
		</ul>
	</div>
	<div>
		<div>
			<div class="grupo">
				<label>Que cumplan</label>
				<div class="grupo-horizontal">
					<p><input type="radio" id="todos" ng-checked="filtros.alguno==0" name="opcion" ng-value="0" ng-model="filtros.alguno"/>Todos</p>
					<p><input type="radio" name="opcion" ng-checked="filtros.alguno==1" ng-value="1" ng-model="filtros.alguno"/>Alguno</p>
				</div>
			</div>
			<div class="grupo">
				<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
				<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Like" bt-auto-complete="completeConocimientos"></div>
			</div>
			
			<div class="grupo">
  				<label><?php echo ucfirst($idioma('oferta_formativa')); ?></label><br>
				<select ng-model='filtros.id_oferta_formativa'>
					<option></option>
				<?php
				foreach ($oferta_formativa as $oferta){
				  echo "<option value= '" .$oferta->id_oferta_formativa ."'>" .$oferta->nombre ."</option>";
				}
				?>
				</select>
			</div>
			<div class="grupo">
				<label><?php echo ucfirst($idioma('fecha_fin_estudios')); ?></label>
				<div bt-date-picker ng-model="filtros.fecha_fin"></div>
			</div>
			
			<div class="grupo">
				<label><?php echo ucfirst($idioma('buscar')); ?></label>
				<input class="buscar" type="text" ng-model="filtros.buscador"/>
			</div>
			<span class="btn btn-tipo" ng-click="buscar()">Buscar</span>
			<span class="btn btn-tipo" ng-click="guardar()">Guardar</span>
		</div>
		<ul>
			<li ng-repeat="alumno in vista"><span>{{alumno.nombre}}</span> <span class="btn" ng-click="seleccionar($index)"><img src="/imagenes/anadir.png"/></span></li>
		</ul>
	</div>
</div>