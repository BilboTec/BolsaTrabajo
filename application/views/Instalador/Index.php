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
			<script src="/api/Localize"></script>
			<?php echo csscrush_tag("/css/style_instal.css"); ?>
		</head>
		<body>
			<div ng-show="paso == 1">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>{{lang[idioma]["bienvenida"]}}</p>
				<ol>
					<li>{{lang[idioma]["nombre_base_datos"] | capitalize}}</li>
					<li>{{lang[idioma]["usuario_de_la_bd"] | capitalize}}</li>
					<li>{{lang[idioma]["clave_de_la_bd"] | capitalize}}</li>
					<li>{{lang[idioma]["servidor_de_la_bd"] | capitalize}}</li>
				</ol>
				<p>{{lang[idioma]["mensaje_pag1"] | capitalize}}<b>database.php</b></p>

				<button class= "btn-centro" ng-click="empezar()">{{lang[idioma]["empezar"] | capitalize}}</button>
			</div>
			
			<form novalidate name="dbconfig" ng-show="paso == 2">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>{{lang[idioma]["mensaje_pag2"] | capitalize}}</p>
				<div class="grupo">
					<label>{{lang[idioma]["nombre_base_datos"] | capitalize}}</label>
					<input name="dbname" ng-required="true" ng-model="config.db.dbname"/>
					<p>{{lang[idioma]["explicacion_nombre"] | capitalize}}</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.dbname.$touched) && dbconfig.dbname.$invalid" 
					class="error-validacion">{{lang[idioma]["error_nombre"] | capitalize}}</span>
				</div>
				
				<div class="grupo">
					<label>{{lang[idioma]["nombre_usuario"] | capitalize}}</label>
					<input name="user" ng-required="true"  ng-model="config.db.user"/>
					<p>{{lang[idioma]["explicacion_nombre_usuario"] | capitalize}}</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.user.$touched) && dbconfig.user.$invalid" 
					class="error-validacion">{{lang[idioma]["error_nombre_usuario"] | capitalize}}</span>
				</div>
				
				<div class="grupo">
					<label>{{lang[idioma]["clave"] | capitalize}}</label>
					<input name="pass" ng-required="true"  ng-model="config.db.pass"/>
					<p>{{lang[idioma]["explicacion_clave"] | capitalize}}</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.pass.$touched) && dbconfig.pass.$invalid" 
					class="error-validacion">{{lang[idioma]["error_clave"] | capitalize}}</span>
				</div>
				
				<div class="grupo">
					<label>{{lang[idioma]["servidor_bd"] | capitalize}}</label>
					<input name="host" ng-required="true"  ng-model="config.db.host"/>
					<p>{{lang[idioma]["explicacion_servidor"] | capitalize}}</p>
					<span ng-show="(dbconfig.$submitted || dbconfig.host.$touched) && dbconfig.host.$invalid" 
					class="error-validacion">{{lang[idioma]["error_servidor"] | capitalize}}</span>
				</div>
				<div class="btn-contenedor btn-centro">
					<button  ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button  ng-click="comprobarDB()">{{lang[idioma]["continuar"] | capitalize}}</button>
				</div>
				<div class="error_estatico" ng-show="error_conexion">{{lang[idioma]["error_conectar"] | capitalize}}</div>
			</form>
			<div ng-show="paso == 3">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p class="titulo">{{lang[idioma]["mensaje_pag3"] | capitalize}}</p>
				<div class="codigo" bt-contenido-html ng-model="texto"></div>
				<div class="btn-contenedor btn-centro">
					<button ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button ng-click="comprobarDBExistente()">{{lang[idioma]["continuar"] | capitalize}}</button>
				</div>
			</div>
			<div ng-show="paso == 4">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p ng-hide="creado">{{lang[idioma]["mensaje_pag4"] | capitalize}}</p>	
				<div ng-hide="creado" class="btn-contenedor btn-centro">
					<button ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button ng-click="crearDB()">{{lang[idioma]["crear"] | capitalize}}</button>
				</div>
				
				<p ng-show="creado">{{lang[idioma]["mensaje_pag4_2"] | capitalize}}</p>	
				<div ng-show="creado" class="btn-contenedor btn-centro">
					<button ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button ng-click="insertarDB()" ng-disabled="insertado">{{lang[idioma]["rellenar"] | capitalize}}</button>
					<button  ng-click="continuar()">{{lang[idioma]["continuar"] | capitalize}}</button>
				</div>

			</div>
			<div ng-show="paso == 5">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>{{lang[idioma]["mensaje_pag5"] | capitalize}}</p>
					<form novalidate name="emailForm" class="centrado">
						<div class="grupo">
							<label>{{lang[idioma]["Smtp_Host"] | capitalize}}</label>
							<input ng-required="true" name="host" ng-model="config.email.host"/>
							<p>{{lang[idioma]["explicacion_Smtp_Host"] | capitalize}}</p>
							<span ng-show="(emailForm.$submitted || emailForm.host.$touched) && emailForm.host.$invalid" 
					class="error-validacion">{{lang[idioma]["error_Smtp_Host"] | capitalize}}</span>
						</div>
						<div class="grupo">
							<label>{{lang[idioma]["puerto"] | capitalize}}</label>
							<input ng-required="true"  type="number" name="port" ng-model="config.email.port"/>
							<p>{{lang[idioma]["explicacion_puerto"] | capitalize}}</p>
							<span ng-show="(emailForm.$submitted || emailForm.port.$touched) && emailForm.port.$invalid" 
					class="error-validacion">{{lang[idioma]["error_puerto"] | capitalize}}</span>
						</div>
						<div class="grupo">
							<label>{{lang[idioma]["usuario"] | capitalize}}</label>
							<input  ng-required="true" name="user" ng-model="config.email.user"/>
							<p>{{lang[idioma]["explicacion_usuario"] | capitalize}}</p>
							<span ng-show="(emailForm.$submitted || emailForm.user.$touched) && emailForm.user.$invalid" 
					class="error-validacion">{{lang[idioma]["error_usuario"] | capitalize}}</span>
						</div>
						<div class="grupo">
							<label>{{lang[idioma]["clave"] | capitalize}}</label>
							<input  ng-required="true" name="pass" ng-model="config.email.pass"/>
							<p>{{lang[idioma]["explicacion_clave2"] | capitalize}}</p>
							<span ng-show="(emailForm.$submitted || emailForm.pass.$touched) && emailForm.pass.$invalid" 
					class="error-validacion">{{lang[idioma]["error_clave2"] | capitalize}}</span>
						</div>
					</form>
					<p>{{lang[idioma]["mensaje_pag5_2"] | capitalize}}</p>
					<form name="enviarEmail" novalidate class="centrado">
						<div class="grupo">
							<label>{{lang[idioma]["direccion_correo"] | capitalize}}</label>
							<input type="email" ng-required="true" ng-model="config.email.prueba" name="email"/>
							<p>{{lang[idioma]["explicacion_direccion_correo"] | capitalize}}</p>
							<span ng-show="(enviarEmail.$submitted || enviarEmail.email.$touched) && enviarEmail.email.$error.required" 
					class="error-validacion">{{lang[idioma]["error_direccion_correo"] | capitalize}}</span>
							<span ng-show="(enviarEmail.$submitted || enviarEmail.email.$touched) && enviarEmail.email.$error.email" 
							class="error-validacion">{{lang[idioma]["error2_direccion_correo"] | capitalize}}</span>
						</div>
						<button type="button" class="btn-probar" ng-click="probarDatosEmail()">{{lang[idioma]["comprobar"] | capitalize}}</button>
					</form>
					<div class="btn-contenedor btn-centro">
						<button  ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
						<button  ng-click="guardarDatosEmail()">{{lang[idioma]["continuar"] | capitalize}}</button>
					</div>
			</div>
			<div ng-show="paso == 6">
				<div>
					<a class="btn-idioma" ng-class="idioma == 'basque'?'active':''" href="#" ng-click="cambiarIdioma('basque')">EU</a>
					<a class="btn-idioma" ng-class="idioma == 'spanish'?'active':''" href="#" ng-click="cambiarIdioma('spanish')">ES</a>
				</div>
				<img class="logo" src="/imagenes/BilboTec.jpg"/>
				<p>{{lang[idioma]["mensaje_pag6"] | capitalize}}</p>
				<ul>
					<li>{{lang[idioma]["usuario_app"] | capitalize}}</li>
					<li>{{lang[idioma]["clave_usuario_app"] | capitalize}}</li>
				</ul>
				<p>{{lang[idioma]["mensaje_pag6_2"] | capitalize}}</p>
				<div class="btn-contenedor btn-centro">
					<button  ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button  ng-click="Instalado()">{{lang[idioma]["finalizar"] | capitalize}}</button>
				</div>
				
			</div>
			<div bt-window="ventana"></div>
		</body>
	</html>
	
	<script>
		angular.module("BilboTec",[]).controller("instalador_controller", ["$scope", "$http", function($scope, $http){
			$scope.idioma = sessionStorage.getItem("idioma");
			if(!$scope.idioma){
				$scope.idioma = "spanish";
			}
			$scope.cambiarIdioma = function(idioma){
				$scope.idioma = idioma;
				sessionStorage.setItem("idioma",idioma);
			};
			$scope.paso = 1;
			$scope.config = {
				db:{
					dbname:"bolsa_trabajo",
					user:"bolsa_trabajo",
					pass:"BolsaTrabajo78",
					host:"localhost"
				},
				email:{
					host:"ssl://smtp.googlemail.com",
					port:465,
					user:"usuario@gmail.com",
					pass:"contraseña"
					
				}
			};
			$scope.empezar = function(){
				$scope.paso = 2;
			};
			$scope.lang = <?php echo json_encode($idioma); ?>;
			function alerta(titulo, contenido){
				$scope.ventana.alerta(titulo, contenido, function(){
					$scope.ventana.cerrar();
				})
			}
			$scope.atras = function(){
				$scope.paso = $scope.paso == 4?2:$scope.paso==1?1:$scope.paso-1;
			};
			
			$scope.continuar = function(){
				$scope.paso++;
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
						$scope.error_conexion = true;
					})
				}
			};
			$scope.probarDatosEmail = function(){
				$scope.enviarEmail.$setSubmitted(true);
						if($scope.enviarEmail.$valid){
							$http({
								url:"/Instalador/ProbarDatosEmail",
								method:"POST",
								data:$.param($scope.config.email),
								headers: {'Content-Type': 'application/x-www-form-urlencoded'}
							}).then(function(respuesta){
								
							},
							function(error){
								
							});
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
						$scope.creado = true;
					},function(error){
						
					})
			}
			
			$scope.insertarDB = function(){
				$scope.paso = 5;
				$scope.insertado = true;
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
			
			$scope.Instalado = function(){
				$http({
					url:"/Instalador/Instalado",	
				})
				.then(
					function(respuesta){
					window.location = "/Login";
					},
					function(error){
						
					}
				)
			}
		}])
		.directive("btContenidoHtml",function(){
			return{
			       restrict: "A",     //Solo en atributos
			       require:"ngModel",   //Requerir que el elemento tenga ngModel, de esta forma estara disponible en la funcion link
			       scope:{//Las variables que estaran disponibles en scope
			            modelo:"=ngModel"
			       },
			       /*Esta funcion seria el controlador del elemento, en este caso no tiene que hacer nada mas que mostrar el contenido de ngModel en formato html*/
			       link:function(scope,elemento,attributos,ngModel){
			               /*Esta funcion sera llamada  cada vez que ngModel cambie, *
			                * la funcion tiene que aplicar los cambios al html de forma   *
			               * rapida                                                                                              */
			              ngModel.$render = function(){ 
			                   elemento[0].innerHTML = scope.modelo;
			               };
			      }
			    };
		}).filter("capitalize",function(){
		    return function(string){
		        if(typeof string === "undefined"){
		            return;
		        }
	        return string.substr(0,1).toUpperCase() + string.substr(1);
    };
})
	</script>