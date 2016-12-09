<div class="contenido" ng-controller="formularioLoginController">
	
	<form class="form-login" name="formLogin" action="/Login" method="POST" ng-submit="alta()">
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0"><?php echo $idioma('alumno'); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1"><?php echo $idioma('empresa'); ?></li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2"><?php echo $idioma('profesor'); ?></li>
		</ul>
		<fieldset>
			<legend><?php echo $idioma('iniciar_sesion'); ?></legend>
		<ul>
			<?php echo validation_errors(); ?>
		</ul>
		<input type="hidden" name="tipo" value="{{tipo}}" />
		<div bt-input-label bt-id="email" ng-requred="true" name="email" type="email" bt-label="'<?php echo $idioma('email'); ?>'" bt-model="email"></div>
		<div bt-input-label bt-id="clave" type="password" bt-label="'<?php echo $idioma('clave'); ?>'" name="clave" bt-model="clave"></div>
		<input type="submit" value="<?php echo $idioma('entrar'); ?>">
		<a href="#"><?php echo $idioma('recordar_clave'); ?></a>
		</fieldset>
		<a ng-show="tipo!==2" href="#"><?php echo $idioma('registrarse'); ?></a>
	</form>
	
</div>