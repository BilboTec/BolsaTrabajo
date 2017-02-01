<div class="contenedor-vertical" ng-init='espana=<?php echo json_encode($espana); ?>;init()'>
	<div ng-if="!editando">
	<div class="grupo-horizontal"><p>{{empresa.nombre}}</p>
		<?php if($es_administrador){ ?>
		<span class="btn btn-tipo" ng-click="editar()"><?php echo mb_ucfirst($idioma('editar')); ?> </span>
		<?php } ?>
	</div>
	<p>{{empresa.email}}</p>
	<p>{{empresa.cif}}</p>
	<p>{{empresa.sector}}</p>
	<p>{{localidad.nombre}}</p>
	<p>{{provincia.nombre}}</p>
	<p>{{pais.nombre}}</p>
	</div>
	<div ng-if="editando" ng-form="form">
		<div class="grupo">
			<label for="nombre"><?php echo mb_ucfirst($idioma('nombre')); ?> </label>
			<input name="nombre" type="text" ng-model="vista.nombre" id="nombre" ng-required="true"/>
			<span class="error_validacion" ng-if="!ocultar && form.nombre.$error.required">El campo nombre es obligatorio</span>
		</div>
		
		<div class="grupo">
			<label for="email"><?php echo mb_ucfirst($idioma('email')); ?> </label>
			<input name="email" type="email" ng-model="vista.email" id="email" ng-required="true"/>
			<span class="error_validacion" ng-if="!ocultar && form.email.$error.required">El campo email es obligatorio</span>
			<span class="error_validacion" ng-if="!ocultar && form.email.$error.email">El campo email tiene que ser un email valido</span>
		</div>
		
		<div class="grupo">
			<label for="cif"><?php echo mb_ucfirst($idioma('cif')); ?> </label>
			<input type="text" ng-model="vista.cif" id="cif"/>
		</div>
		
		<div class="grupo">
			<label for="sector"><?php echo mb_ucfirst($idioma('sector')); ?> </label>
			<input type="text" ng-model="vista.sector" id="sector"/>
		</div>
		
		<div class="grupo">
			<label for="provincia"><?php echo ucfirst($idioma("provincia")); ?></label>
			<select name="id_provincia" id="provincia" ng-disabled="provinciasDisabled" ng-model="provincia.id_provincia" ng-change="cargarLocalidades()">
			<?php
				foreach ( $provincias as $provincia) {
					echo "<option value='" .$provincia->id_provincia ."'>" .$provincia->nombre ."</option>";
				}
			?>
			</select>
		</div>

		<div class="grupo">
			<label for="localidad"><?php echo ucfirst($idioma("localidad")); ?></label>
			<select name="id_localidad" ng-disabled="provinciasDisabled" id="localidad" ng-model="vista.id_localidad">
				<option ng-repeat="localidad in localidades" value="{{localidad.id_localidad}}">{{localidad.nombre}}</option>
			</select>
		</div>
		
		<div class="grupo">
			<label for="pais"><?php echo ucfirst($idioma("pais")); ?></label>
			<select name="id_pais" id="pais" ng-model="vista.id_pais" ng-change="comprobarPais()">
			<?php
				foreach ( $paises as $pais) {
					echo "<option value='" .$pais->id_pais ."'>" .$pais->nombre ."</option>";
				}
			?>
			</select>
		</div>
		<div class="grupo-horizontal">
			<span class="btn btn-tipo" ng-click="guardar()"> <?php echo mb_ucfirst($idioma('guardar')); ?></span>
			<span class="btn btn-tipo" ng-click="cancelar()"> <?php echo mb_ucfirst($idioma('cancelar')); ?></span>
		</div>
	</div>
	<a href="#/!" class="btn btn-tipo"><?php echo ucfirst($idioma("volver")); ?></a>
</div>
