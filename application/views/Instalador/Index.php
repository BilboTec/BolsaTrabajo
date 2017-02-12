<!DOCTYPE html>
	<html ng-app="BilboTec" ng-controller="instalador_controller">
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<script src="/js/jquery-3.1.1.min.js"></script>
			<script src="/js/angular.min.js"></script>
			<script src="/js/angular-animate.js"></script>
			<script src="/js/angular-route.js"></script>
			<script src="/js/BilboTec.js"></script>
			<script src="/js/BilboTec.ui.js"></script>
			<?php echo csscrush_tag("/css/style_instal.css"); ?>
		</head>
		<body>
			<div ng-show="paso == 1">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>Bienvenido a la Bolsa de Trabajo de BilboTec&copy;. Antes de empezar necesitamos alguna información de la base de datos.
				Necesitarás saber lo siguiente antes de continuar.</p>
				<ol>
					<li>Nombre de la base de datos</li>
					<li>Usuario de la base de datos</li>
					<li>Contraseña de la base de datos</li>
					<li>Servidor de la base de datos</li>
				</ol>
				<p>Vamos a utilizar esta información para crear el archivo de configuración <b>database.php</b></p>
				<button class= "btn-centro" ng-click="empezar()">Empezar</button>
			</div>
			
			<form name="dbconfig" ng-show="paso == 2">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>A continuación deberás introducir los detalles de conexión a tu base de datos. 
					Si no estás seguro de esta información contacta con tu proveedor de alojamiento web.</p>
				<div class="grupo">
					<label>Nombre de la base de datos</label>
					<input name="dbname" ng-required="true" ng-model="config.db.dbname"/>
					<p>El nombre de la base de datos que quieres usar para la Bolsa de Trabajo.</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.dbname.$touched) && dbconfig.dbname.$invalid" 
					class="error-validacion">El campo nombre de la base de datos es obligatorio</span>
				</div>
				
				<div class="grupo">
					<label>Nombre de usuario</label>
					<input name="user" ng-required="true"  ng-model="config.db.user"/>
					<p>El nombre de usuario de tu base de datos.</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.user.$touched) && dbconfig.user.$invalid" 
					class="error-validacion">El campo nombre de usuario de la base de datos es obligatorio</span>
				</div>
				
				<div class="grupo">
					<label>Contraseña</label>
					<input name="pass" ng-required="true"  ng-model="config.db.pass"/>
					<p>La contraseña de tu base de datos.</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.pass.$touched) && dbconfig.pass.$invalid" 
					class="error-validacion">El campo contraseña de la base de datos es obligatorio</span>
				</div>
				
				<div class="grupo">
					<label>Servidor de la base de datos</label>
					<input name="host" ng-required="true"  ng-model="config.db.host"/>
					<p>Deberías recibir esta información de tu proveedor de alojamiento web, si localhost no funciona.</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.host.$touched) && dbconfig.host.$invalid" 
					class="error-validacion">El campo nombre del host es obligatorio</span>
				</div>
				<button class= "btn-centro" ng-click="comprobarDB()">Continuar</button>
			</form>
			<div ng-show="paso == 3">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p class="titulo">No se ha podido generar automáticamente la configuración de la base de datos.
					Sustuya el contenido de "application/config/database.php" por el siguiente</p>
				<div class="codigo" bt-contenido-html ng-model="texto"></div>
				<button class= "btn-centro" ng-click="comprobarDBExistente()">Continuar</button>
			</div>
			<div ng-show="paso == 4">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>La configuración ha sido realizada con éxito, para crear la base de datos pulse el botón crear.</p>	
				<button class="btn-centro" ng-click="crearDB()">Crear</button>
			</div>
			<div ng-show="paso == 5">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>Para configurar el remitente de los correos de notificación de la aplicación
					rellene el siguiente formulario</p>
					<form name="emailForm" class="centrado">
						<div class="grupo">
							<label>Smtp Host</label>
							<input ng-required="true" name="host" ng-model="config.email.host"/>
							<p>La dirección del servidor que enviará el email</p>
							<span ng-show="(emailForm.$submitted || emailForm.host.$touched) && emailForm.host.$invalid" 
					class="error-validacion">El campo host es obligatorio</span>
						</div>
						<div class="grupo">
							<label>Puerto</label>
							<input ng-required="true"  type="number" name="port" ng-model="config.email.port"/>
							<p>El puerto utilizado por el servidor</p>
							<span ng-show="(emailForm.$submitted || emailForm.port.$touched) && emailForm.port.$invalid" 
					class="error-validacion">El campo puerto es obligatorio</span>
						</div>
						<div class="grupo">
							<label>Usuario</label>
							<input  ng-required="true" name="user" ng-model="config.email.user"/>
							<p>El nombre de usuario de la cuenta de correo</p>
							<span ng-show="(emailForm.$submitted || emailForm.user.$touched) && emailForm.user.$invalid" 
					class="error-validacion">El campo usuario es obligatorio</span>
						</div>
						<div class="grupo">
							<label>Contraseña</label>
							<input  ng-required="true" name="pass" ng-model="config.email.pass"/>
							<p>La contraseña del correo electrónico</p>
							<span ng-show="(emailForm.$submitted || emailForm.pass.$touched) && emailForm.pass.$invalid" 
					class="error-validacion">El campo contraseña es obligatorio</span>
						</div>
					</form>
					<button class="btn-centro" ng-click="guardarDatosEmail()">Continuar</button>
			</div>
			<div ng-show="paso == 6">
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>La aplicación se ha instalado correctamente. Se ha creado un administrador con los siguientes datos:</p>
				<ul>
					<li>Usuario: admin@bolsatrabajo.es</li>
					<li>Contraseña: admin</li>
				</ul>
				<p>Pulse el siguiente botón para completar la instalación</p>
				
			</div>
		</body>
	</html>
	
	<script>
		angular.module("BilboTec").controller("instalador_controller", ["$scope", "$http", function($scope, $http){
			$scope.paso = 1;
			$scope.config = {
				db:{
					dbname:"bolsa_trabajo",
					user:"bolsa_trabajo",
					pass:"BolsaTrabajo78",
					host:"localhost"
				},
				email:{
					
				}
			};
			$scope.empezar = function(){
				$scope.paso = 2;
			}
			$scope.comprobarDB = function(){
				$scope.dbconfig.$setSubmitted(true);
				if($scope.dbconfig.$valid){
					$http({
						url:"/Instalador/ComprobarDB",
						data:$.param($scope.config.db),
						method:"POST",
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					})
					.then(function(respuesta){
						EscribirConfDB();
					},function(error){
						
					})
				}
			};
			$scope.guardarDatosEmail = function(){
				$scope.emailForm.$setSubmitted(true);
				if($scope.emailForm.$valid){
					$http({
						url:"/Instalador/GuardarDatosEmail",
						method:"POST",
						data:$.param($scope.config.email),
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).then(function(respuesta){
						$scope.paso = 6;
					},
					function(error){
						
					});
				}
			}
			$scope.crearDB = function(){
				$http({
						url:"/Migraciones"
					})
					.then(function(respuesta){
						$scope.paso = 5;
					},function(error){
						
					})
			}
			$scope.comprobarDBExistente = function(){
				$http({
						url:"/Instalador/ComprobarDBExistente"
					})
					.then(function(respuesta){
						$scope.paso = 4;
					},function(error){
						
					})
			};
			function EscribirConfDB(){
				$http({
						url:"/Instalador/EscribirConfDB",
						data:$.param($scope.config.db),
						method:"POST",
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					})
					.then(function(respuesta){
						$scope.paso = 4;
					},function(error){
						$scope.texto = error.data;
						$scope.paso = 3;
					})
			}
		}])
	</script>