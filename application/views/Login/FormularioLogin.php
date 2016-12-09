<div class="contenido" ng-controller="formularioLoginController">
	
	<form class="form-login" name="formLogin" action="/Login" method="POST" ng-submit="alta()">
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0">Alumno</li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1">Empresa</li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2">Profesor</li>
		</ul>
		<fieldset>
			<legend>INICIO DE SESIÓN</legend>
		<ul>
			<?php echo validation_errors(); ?>
		</ul>
		<input type="hidden" name="tipo" value="{{tipo}}" />
		<div bt-input-label bt-id="email" ng-requred="true" name="email" type="email" bt-label="'Email'" bt-model="email"></div>
		<div bt-input-label bt-id="clave" type="password" bt-label="'Clave'" name="clave" bt-model="clave"></div>
		<input type="submit" value="Entrar">
		<a href="#">Recordar contraseña</a>
		</fieldset>
		<a ng-show="tipo!==2" href="#">Registrarse</a>
	</form>
	
</div>