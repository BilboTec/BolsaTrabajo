<div class="grupo">
	<label for="nombre">Nombre</label>
	<input id="nombre" ng-model="usuario.nombre"/>
</div>

<div class="grupo">
	<label for="apellido">Primer Apellido</label>
	<input id="apellido" ng-model="usuario.apellido"/>
</div>

<div class="grupo">
	<label for="apellido2">Segundo Apellido</label>
	<input id="apellido2" ng-model="usuario.apellido2"/>
</div>

<div class="grupo">
	<label for="departamento">Departamento</label>
	<select id="departamento" ng-model="usuario.id_departamento">
	<?php 
		foreach ($departamentos as $departamento) {
			echo "<option value='" .$departamento->id_departamento ."'>" .$departamento->nombre ."</option>";
		}
	?>
	</select>
</div>

<div class="grupo">
	<label for="rol">Rol</label>
	<select id="rol" ng-model="usuario.id_rol">
	<?php 
		$roles = [1=>"User", 2=>"Manager", 3=>"Admin"];
		foreach ($roles as $id=>$rol) {
			echo "<option value='" .$id ."'>" .$rol ."</option>";
		}
	?>
	</select>
</div>

<button ng-click="guardar()">Guardar</button>
<a href="#!/">Volver</a>