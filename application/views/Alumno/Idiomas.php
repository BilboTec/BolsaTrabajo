<div class="contenedor-idioma">
	<div ng-controller="alumnoPerfilIdiomasController" ng-init='niveles=<?php
		echo json_encode([$idioma("basico"),$idioma("intermedio"),$idioma("avanzado")]);
	 ?>;'>
	<div class="titulo-con-boton">
		<h1><?php echo strtoupper($idioma("idiomas")); ?></h1>
		<span class="btn btn-tipo" ng-show="!insertando" ng-click="insertar()"><?php echo ucfirst($idioma("anadir_idioma")); ?></span>
	</div>
		<div ng-show="insertando">
			<div class="grupo-horizontal">
				<div class="grupo">
					<label for="vistaNombre"><?php echo ucfirst($idioma("idioma")) ?></label>
					<input type="text" ng-model="vista.nombre"/>
				</div>
				<div class="grupo">
					<label for="vistaNivel"><?php echo ucfirst($idioma("nivel")); ?></label>
					<select id="vistaNivel" ng-model="vista.nivel">
						<option value="1"><?php echo ucfirst($idioma("basico")); ?></option>
						<option value="2"><?php echo ucfirst($idioma("intermedio")); ?></option>
						<option value="3"><?php echo ucfirst($idioma("avanzado")); ?></option>
					</select>
				</div>
			</div>
			<div class="grupo">
				<label for="vistaOficial"><input type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-model="vista.oficial"/><?php echo ucfirst($idioma("oficial")); ?></label>
			</div>
		</div>
		<div ng-repeat="idioma in idiomas track by $index">
			<div ng-show="indiceEdicion === $index">
				<div class="grupo-horizontal">
					<div class="grupo">
						<label for="vistaNombre"><?php echo ucfirst($idioma("idioma")) ?></label>
						<input type="text" ng-model="vista.nombre"/>
					</div>
					<div class="grupo">
						<label for="vistaNivel"><?php echo ucfirst($idioma("nivel")); ?></label>
						<select id="vistaNivel" ng-model="vista.nivel">
							<option ng-repeat="nivel in niveles" value="{{($index+1).toString()}}">{{nivel}}</option>
						</select>
					</div>
				</div>
				<div class="grupo">
					<label for="vistaOficial"><input type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-model="vista.oficial"/><?php echo ucfirst($idioma("oficial")); ?></label>
				</div>
				<span class="btn btn-tipo" ng-click="aplicarEdicion($index)">Guardar</span>
				<span class="btn btn-tipo" ng-click="cancelar()">Cancelar</span>
			</div>
			<div ng-show="indiceEdicion !== $index">
				<div class="grupo-horizontal space-between">
					<div class="grupo-horizontal">
						<p>{{idioma.nombre}} {{$parent.niveles[idioma.nivel - 1]}}</p>
						<p ng-if="idioma.oficial==1"><?php echo ucfirst($idioma("oficial")); ?></p>
					</div>
					<div class="grupo-horizontal">
						 <span title="<?php echo ucfirst($idioma("editar")); ?>" class="btn btn-tabla btn-editar" ng-click="editar($index)"><img src="/imagenes/editar.png"/></span>
						 <span title="<?php echo ucfirst($idioma("eliminar")); ?>" class="btn btn-tabla btn-eliminar" ng-click="eliminar($index)"><img src="/imagenes/eliminar.png"/></span>
					</div>
				</div>
			</div>
		</div>
		<div>
			<span class="btn btn-tipo" ng-click="aplicarInsertar()" ng-show="insertando"><?php echo strtoupper($idioma("guardar")); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar()" ng-show="insertando"><?php echo strtoupper($idioma("cancelar")); ?></span>
		</div>
	</div>
</div>