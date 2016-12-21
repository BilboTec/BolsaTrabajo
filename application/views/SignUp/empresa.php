<form action="/SignUp/Empresa" method="POST">
	<fieldset>
			<legend><?php echo strtoupper($idioma('iniciar_sesion')); ?></legend>
			<div class="login-contenedor">
				<div class="grupo-form">
				<input type="hidden" name="tipo" value="{{tipo}}" />
					<div bt-input-label bt-id="nombre" ng-required="true" name="nombre" type="text" bt-label="'<?php echo ucfirst($idioma('nombre')); ?>'" bt-model="nombre"></div>
					<?php echo form_error("nombre",'<div class="error-validacion" ng-hide="formLogin.nombre.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.nombre.$touched) && formLogin.nombre.$error.required"><?php printf($idioma("required"),$idioma("nombre")); ?></div>
				</div>
				<div class="grupo-form">
				<input type="hidden" name="tipo" value="{{tipo}}" />
					<div bt-input-label bt-id="email" ng-required="true" name="email" type="email" bt-label="'<?php echo ucfirst($idioma('email')); ?>'" bt-model="email"></div>
					<?php echo form_error("email",'<div class="error-validacion" ng-hide="formLogin.email.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.email"><?php printf($idioma("valid_email"),$idioma("email")); ?></div>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.required"><?php printf($idioma("required"),$idioma("email")); ?></div>
				</div>
				<input type="submit" value="<?php echo ucfirst($idioma('registrarse')); ?>">
			</div>
		</fieldset>
</form>