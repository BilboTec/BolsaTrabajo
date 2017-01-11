<div class="grupo">
	<label for="clave">Contraseña Actual</label>
	<input type="password" id="clave" ng-model="usuario.clave"/>
</div>

<div class="grupo">
	<label for="nuevaclave">Contraseña Nueva</label>
	<input type="password" id="nuevaclave" ng-model="usuario.nuevaclave"/>
</div>

<div class="grupo">
	<label for="repetirclave">Repita Su Contraseña</label>
	<input type="password" id="repetirclave" ng-model="usuario.repetirclave"/>
</div>

<button ng-click="cambiarClave()">Cambiar</button>
<a href="#!/">Volver</a>
