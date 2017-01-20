<div ng-controller="alumnoPerfilIdiomasController" ng-init='niveles=<?php
	echo json_encode([$idioma("basico"),$idioma("intermedio"),$idioma("avanzado")]);
 ?>;'>
	<h1><?php echo strtoupper($idioma("idiomas")); ?></h1>
	<button ng-click="insertar()">Añadir Idioma</button>
	<div ng-show="insertando">
		<div class="grupo-horizontal">
			<div class="grupo">
				<label for="vistaNombre"><?php echo ucfirst($idioma("idioma")) ?></label>
				<input type="text" ng-model="vista.nombre"/>
				<button ng-click="aplicarInsertar()">V</button>
				<button ng-click="cancelar()">O</button>
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
			<label for="vistaOficial"><input type="checkbox" ng-model="vista.oficial"/><?php echo ucfirst($idioma("oficial")); ?></label>
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
				<button ng-click="aplicarEdicion($index)">V</button>
				<button ng-click="cancelar()">O</button>
			</div>
			<div class="grupo">
				<label for="vistaOficial"><input type="checkbox" ng-model="vista.oficial"/><?php echo ucfirst($idioma("oficial")); ?></label>
			</div>
		</div>
		<div ng-show="indiceEdicion !== $index">
			<div class="grupo-horizontal">
				<p>{{idioma.nombre}} {{$parent.niveles[idioma.nivel - 1]}}
				 <button ng-click="editar($index)">Editar</button>
				 <button ng-click="eliminar($index)">Eliminar</button>
				</p>
			</div>
			<p ng-if="idioma.oficial==1"><?php echo ucfirst($idioma("oficial")); ?></p>
		</div>
	</div>
</div>