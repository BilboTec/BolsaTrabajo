<div class="grupo">
<h1 class="titulo"><?php echo strtoupper($idioma("editar_perfil")); ?></h1>
<div class="grupo">
	<label for="nombre"><?php echo ucfirst($idioma("nombre")); ?></label>
	<input id="nombre" ng-model="usuario.nombre"/>
</div>
<div class="grupo">
	<label for="apellido"><?php echo ucfirst($idioma("apellido1")); ?></label>
	<input id="apellido" ng-model="usuario.apellido"/>
</div>

<div class="grupo">
	<label for="apellido2"><?php echo ucfirst($idioma("apellido2")); ?></label>
	<input id="apellido2" ng-model="usuario.apellido2"/>
</div>

<div class="grupo">
	<label for="departamento"><?php echo ucfirst($idioma("departamento")); ?></label>
	<select id="departamento" ng-model="usuario.id_departamento">
	<?php 
		foreach ($departamentos as $departamento) {
			echo "<option value='" .$departamento->id_departamento ."'>" .$departamento->nombre ."</option>";
		}
	?>
	</select>
</div>

<div class="grupo">
	<label for="rol"><?php echo ucfirst($idioma("rol")); ?></label>
	<select id="rol" ng-model="usuario.id_rol">
	<?php 
		$roles = [1=>"User", 2=>"Manager", 3=>"Admin"];
		foreach ($roles as $id=>$rol) {
			echo "<option value='" .$id ."'>" .$rol ."</option>";
		}
	?>
	</select>
</div>

<span class="btn-tipo btn" ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></span>
<a href="#!/"><?php echo ucfirst($idioma("volver")); ?></a>
</div>