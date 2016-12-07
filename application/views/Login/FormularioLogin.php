<div class="contenido" ng-controller="formularioLoginController">
	
	<form class="form-login" name="formLogin">
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0">Alumno</li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1">Empresa</li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2">Profesor</li>
		</ul>
		<ul>
			<?php echo validation_errors(); ?>
		</ul>
		<div bt-input-label bt-id="email" ng-requred="true" name="email" type="email" bt-label="'Email'" bt-model="email"></div>
		<div bt-input-label bt-id="clave" type="password" bt-label="'Clave'" bt-model="clave"></div>
		<input type="submit" value="Entrar">
		<a href="#">Recordar contraseña</a>
		<a ng-show="tipo!==2" href="#">Registrarse</a>
	</form>
	
</div>