<div ng-controller="btEditarFormacionAcademica">
	<div class="grupo">
		<label for="nombre"><?php echo $idioma("nombre"); ?></label>
		<input id="nombre" type="text" ng-model="formacion.nombre"/>
	</div>
	<div class="grupo">
		<label for="id_tipo_titulacion"><?php echo $idioma("nombre"); ?></label>
		<select ng-change="cargarOfertas()" id="id_tipo_titulacion" ng-model="formacion.id_tipo_titulacion">
			<?php 
				if(isset($tipo_titulacion)){
					foreach($tipo_titulacion as $tipo){
						echo "<option value='" . $tipo->id_tipo_titulacion."'>".$tipo->nombre."</option>";
					}
				}
			?>
		</select>
	</div>
	<div class="grupo">
		<label for="id_oferta_formativa"><?php echo $idioma("nombre"); ?></label>
		<select id="id_oferta_formativa" ng-model="formacion.id_oferta_formativa">
			<option ng-repeat="oferta in ofertas track by $index" value="{{oferta.id_oferta_formativa}}">{{oferta.nombre}}</option>
		</select>
	</div>
	<div class="grupo">
		<label for="fecha_inicio"><?php echo ucfirst($idioma("fecha_inicio")); ?></label>
		<div bt-date-picker ng-model="vista.fecha_inicio"></div>
	</div>
	
	<div class="grupo" ng-show="!vista.cursando">
		<label for="fecha_fin"><?php echo ucfirst($idioma("fecha_fin")); ?></label>
		<div ng-disabled="vista.cursando" bt-date-picker ng-model="vista.fecha_fin"></div>
	</div>
	
	<div class="grupo">
		<label for="cursando"><input ng-change="onCursando_change()" 
			id="cursando" type="checkbox" ng-model="vista.cursando"
			ng-true-value="1" ng-false-value="0" ng-checked="vista.cursando == 1"/><?php echo ucfirst($idioma("trabajando_actualmente")); ?></label>	
	</div>
	<div class="grupo">
		<label for="fecha_inicio"><?php echo ucfirst($idioma("descripcion")); ?></label>
		<div bt-editor ng-model="vista.descripcion"></div>
	</div>
	<button ng-click="guardar()">Guardar</button>
	<button ng-click="cancelar()">Cancelar</button>
</div>
