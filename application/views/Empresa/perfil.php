<div ng-controller="controladorDatosEmpresa" name="formPerfil" class="contenedor-perfil contenedor" ng-init='espana=<?php echo json_encode($espana); ?>;empresa=<?php echo json_encode($user); ?>;init()'>
	<div bt-window="ventana"></div>
	<div ng-if="editando === 0">
		<div class="grupo-horizontal">
			<h1>{{empresa.nombre}}</h1>
			<span class="btn btn-tipo" ng-click="editar()"><?php echo mb_ucfirst($idioma('editar')); ?></span>
			<span class="btn btn-tipo" ng-click="mostrarcambiarclave()"><?php echo mb_ucfirst($idioma('cambiar_clave')); ?></span>
		</div>
		<p>{{empresa.email}}</p>
		<p>{{empresa.cif}}</p>
		<p>{{empresa.sector}}</p>
		<p>{{provincias.nombre}}</p>
		<p>{{localidad.nombre}}</p>
		<p>{{pais}}</p>
		


	</div>
	<div ng-if="editando === 1">
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
	
	<div ng-if="editando === 2">
		<fieldset>
			<legend><?php echo strtoupper($idioma("cambiar_clave")); ?></legend>
			<div ng-if="!ocultar_clave" bt-input-label bt-id="clave" ng-required="true" name="clave" bt-label="'<?php echo ucfirst($idioma("clave_actual")); ?>'" bt-model="usuario.clave" type="password"></div>
			<div ng-if="!ocultar_clave" ng-show="(formPerfil.$submitted || formPerfil.clave.$touched) && formPerfil.clave.$invalid"><?php printf($idioma("required"),$idioma("clave_actual")); ?></div>
		
			<div bt-input-label bt-id="nuevaclave" ng-required="true" name="nuevaclave" bt-label="'<?php echo ucfirst($idioma("clave_nueva")); ?>'" bt-model="usuario.nuevaclave" type="password"></div>
		
			<div  ng-show="(formPerfil.$submitted || formPerfil.nuevaclave.$touched) && formPerfil.nuevaclave.$invalid"><?php printf($idioma("required"),$idioma("clave_nueva")); ?></div>
		
			<div bt-input-label bt-id="repetirclave" ng-required="true" name="repetirclave" bt-label="'<?php echo ucfirst($idioma("repetir_clave")); ?>'" bt-model="usuario.repetirclave" type="password"></div>
		
			<div  ng-show="(formPerfil.$submitted || formPerfil.repetirclave.$touched) && formPerfil.repetirclave.$invalid"><?php printf($idioma("required"),$idioma("repetir_clave")); ?></div>
		
			<span class="btn btn-tipo" ng-click="cambiarClave()"><?php echo ucfirst($idioma("cambiar")); ?></span>
			<span ng-click="cancelar()"><?php echo ucfirst($idioma("volver")); ?></span>
		</fieldset>
	</div>
</div>