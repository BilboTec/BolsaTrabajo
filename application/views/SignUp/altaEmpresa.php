
<form action="/SignUp/AltaEmpresa" method="post" ng-controller="altaEmpresaController" ng-init="empresa={<?php 
	echo "email:'".$empresa->email."',id_pais:'".$es."'};id_es='".$es."';identificador='".$identificador;
?>'" novalidate ng-submit="onSubmit($event)" name="formAltaEmpresa">
	<fieldset class="contenedor contenedor-alta-empresa" >
		<legend>ALTA EMPRESA</legend>
		<input type="hidden" name="identificador" value="{{identificador}}">
		<div class="grupo-form-flex">
			<div class="grupo-form-flex">
				<label for="cif">CIF</label>
				<input type="text" name="cif" id="cif" ng-model="empresa.cif"/>
			</div>
			<div class="grupo-form-flex">
				<label for="sector">Sector</label>
				<input type="text" id="sector" name="sector" ng-model="empresa.sector" />
			</div>
			<div class="grupo-form-flex">
				<label for="nombre">Nombre</label>
				<input ng-required="true" type="text" id="nombre" name="nombre" ng-model="empresa.nombre" />
			</div>
			<div class="grupo-form-flex">
				<label for="email">Email</label>
				<input type="hidden" name="email" value="{{empresa.email}}"/>
				<input id="email" type="email" name="email" disabled="disabled" ng-model="empresa.email">
				<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.email"><?php printf($idioma("valid_email"),$idioma("email")); ?></div>
				<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.required"><?php printf($idioma("required"),$idioma("email")); ?></div>
			</div>
			<div class="grupo-form-flex">
				<label for="clave">Contraseña</label>
				<input type="password" id="clave" type="text" name="clave" ng-model="empresa.clave" />
				<div class="error-validacion" ng-show="(formLogin.$submitted || formAltaEmpresa.clave.$touched) && fromAltaEmpresa.clave.$error.required ||formAltaEmpresa.clave.$error.required"><?php printf($idioma("required"),$idioma("clave")); ?></div>
				<label for="clave2">Repita la contraseña</label>
				<input type="password" id="clave2" type="text" name="clave2" ng-model="empresa.clave2" />
				<div class="error-validacion" ng-show="(formLogin.$submitted || formAltaEmpresa.clave2.$touched) && fromAltaEmpresa.clave.$error.required ||formAltaEmpresa.clave2.$error.required"><?php printf($idioma("required"),$idioma("clave")); ?></div>
				<div class="error-validacion" ng-show="(formAltaEmpresa.clave.$touched && formAltaEmpresa.clave2.$touched) && emresa.clave != empresa.clave2">Ambos campos tienen que ser iguales</div>

			</div>
			<div class="grupo-form-flex">
				<label for="id_pais">Pais</label>
				<select id="id_pais" ng-change="onPaisCambiado()" name="id_pais" ng-model="empresa.id_pais">
					<?php
						foreach($paises as $pais){
							echo "<option value='".$pais->id_pais."'>".$pais->nombre."</option>";
						}
					?>
				</select>
			</div>
			<div class="grupo-form-flex">
				<label for="id_provincia">Provincia</label>
				<select id="empresa.id_provincia" ng-disabled="!hayProvincias" ng-change="onProvinciaCambiada()" name="id_provincia" ng-model="empresa.id_provincia">
					<?php
						foreach($provincias as $provincia){
							echo "<option value='".$provincia->id_provincia."'>".$provincia->nombre."</option>";
						}
					?>
				</select>
			</div>
			<div class="grupo-form-flex">
				<label for="id_localidad">Localidad</label>
				<select id="id_localidad" ng-disabled="!hayLocalidades" name="id_localidad" ng-model="empresa.id_localidad">
					<option ng-repeat="localidad in localidades" value="{{localidad.id_localidad}}">{{localidad.nombre}}</option>
				</select>
			</div>
			<input type="submit" value="REGISTRARSE"/>
		</div>
	</fieldset>
</form>