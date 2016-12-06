<div class="contenido" ng-controller="formularioLoginController">
	
	<form class="form-login">
		<ul>
			<li class= "btn btn-tipo" ng-class="tipo==0?'activo':''" ng-click="tipo=0">Alumno</li>
			<li class= "btn btn-tipo" ng-class="tipo==1?'activo':''" ng-click="tipo=1">Empresa</li>
			<li class= "btn btn-tipo" ng-class="tipo==2?'activo':''" ng-click="tipo=2">Profesor</li>
		</ul>
		<div bt-input-label texto="Email" ng-model="email"></div>
		<div bt-input-label texto="Clave" ng-model="clave"></div>
		<input type="submit" value="Entrar">
		<a href="#">Recordar contraseña</a>
		<a ng-show="tipo!==2" href="#">Registrarse</a>
	</form>
	
</div>