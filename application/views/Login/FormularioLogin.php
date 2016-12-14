<div class="contenido" ng-controller="formularioLoginController">
	
	<form class="form-login" name="formLogin" action="/Login" method="POST" ng-submit="alta()">
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0"><?php echo ucfirst($idioma('alumno')); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1"><?php echo ucfirst($idioma('empresa')); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2"><?php echo ucfirst($idioma('profesor')); ?></li>
		</ul>
		<fieldset>
			<legend><?php echo strtoupper($idioma('iniciar_sesion')); ?></legend>
			<div class="login-contenedor">
				<ul>
					<?php echo validation_errors(); ?>
				</ul>
				<input type="hidden" name="tipo" value="{{tipo}}" />
				<div bt-input-label bt-id="email" ng-requred="true" name="email" type="email" bt-label="'<?php echo ucfirst($idioma('email')); ?>'" bt-model="email"></div>
				<div bt-input-label bt-id="clave" type="password" bt-label="'<?php echo ucfirst($idioma('clave')); ?>'" name="clave" bt-model="clave"></div>
				<input type="submit" value="<?php echo ucfirst($idioma('entrar')); ?>">
				<a href="#"><?php echo ucfirst($idioma('recordar_clave')); ?></a>
			</div>
		</fieldset>
		<a ng-show="tipo!==2" href="#"><?php echo ucfirst($idioma('registrarse')); ?></a>

	</form>
	
</div>