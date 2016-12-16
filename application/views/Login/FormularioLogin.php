<div class="contenido" ng-controller="formularioLoginController">
	
	<form novalidate class="form-login" name="formLogin" action="/Login" method="POST" ng-submit="validarLogin($event)"
	 <?php
		echo 'ng-init="tipo='.set_value("tipo","0").";email='".set_value("email","")."'".'"';
 ?>>
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0"><?php echo ucfirst($idioma('alumno')); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1"><?php echo ucfirst($idioma('empresa')); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2"><?php echo ucfirst($idioma('profesor')); ?></li>
		</ul>
		<fieldset>
			<legend><?php echo strtoupper($idioma('iniciar_sesion')); ?></legend>
			<div class="login-contenedor">
				<div class="grupo-form">
				<input type="hidden" name="tipo" value="{{tipo}}" />
					<div bt-input-label bt-id="email" ng-required="true" name="email" type="email" bt-label="'<?php echo ucfirst($idioma('email')); ?>'" bt-model="email"></div>
					<?php echo form_error("email",'<div class="error-validacion" ng-hide="formLogin.email.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.email"><?php printf($idioma("valid_email"),$idioma("email")); ?></div>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.email.$touched) && formLogin.email.$error.required"><?php printf($idioma("required"),$idioma("email")); ?></div>
				</div>
				<div class="grupo-form">
					<div bt-input-label bt-id="clave" ng-required="true" type="password" bt-label="'<?php echo ucfirst($idioma('clave')); ?>'" name="clave" bt-model="clave"></div>
					<?php echo form_error("clave",'<div class="error-validacion" ng-hide="formLogin.clave.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(formLogin.$submitted || formLogin.clave.$touched) && formLogin.clave.$invalid"><?php printf($idioma("required"),$idioma("clave")); ?></div>
				</div>
				<input type="submit" value="<?php echo ucfirst($idioma('entrar')); ?>">
				<a href="#"><?php echo ucfirst($idioma('recordar_clave')); ?></a>
			</div>
		</fieldset>
		<a class="registrarse" ng-show="tipo!==2" href="#"><?php echo strtoupper($idioma('registrarse')); ?></a>

	</form>
	
</div>