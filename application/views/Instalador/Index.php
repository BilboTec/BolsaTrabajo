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
			<section class="cargando-mascara" ng-show="cargando">
			</section>
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

				<button bt-btn-carga ng-model="cargando" class= "btn-centro" ng-click="empezar()">{{$parent.lang[$parent.idioma]["empezar"] | capitalize}}</button>
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
					<button bt-btn-carga ng-model="cargando" ng-click="comprobarDB()">{{$parent.lang[$parent.idioma]["continuar"] | capitalize}}</button>
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
					<button bt-btn-carga ng-model="cargando" ng-click="comprobarDBExistente()">{{$parent.lang[$parent.idioma]["continuar"] | capitalize}}</button>
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
					<button bt-btn-carga ng-model="cargando" ng-click="crearDB()">{{$parent.lang[$parent.idioma]["crear"] | capitalize}}</button>
				</div>
				
				<p ng-show="creado">{{lang[idioma]["mensaje_pag4_2"] | capitalize}}</p>	
				<div ng-show="creado" class="btn-contenedor btn-centro">
					<button ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
					<button bt-btn-carga ng-model="cargando" ng-click="insertarDB()" ng-disabled="insertado">{{$parent.lang[$parent.idioma]["rellenar"] | capitalize}}</button>
					<button bt-btn-carga ng-model="cargando" ng-click="continuar()">{{$parent.lang[$parent.idioma]["continuar"] | capitalize}}</button>
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
							<label>{{lang[idioma]["Smtp_Protocol"]}}</label>
							<select ng-model="config.email.protocol">
								<option value="smtp">Smtp</option>
								<option value="mail">Mail</option>
								<option value="sendmail">SendMail</option>
							</select>
							<p>{{lang[idioma]["explicacion_Smtp_Protocol"]}}</p>
						</div>
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
						<div class="grupo">
							<label>{{lang[idioma]["email_encriptacion"] | capitalize}}</label>
							<select ng-model="config.email.crypto">
								<option value="ssl">SSL</option>
								<option value="tsl">TSL</option>
							</select>
							<p>{{lang[idioma]["explicacion_email_encriptacion"] | capitalize}}</p>
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
						<button bt-btn-carga ng-model="cargando" type="button" class="btn-probar" ng-click="probarDatosEmail()">{{$parent.lang[$parent.idioma]["comprobar"] | capitalize}}</button>
					</form>
					<div class="btn-contenedor btn-centro">
						<button  ng-click="atras()">{{lang[idioma]["atras"] | capitalize}}</button>
						<button bt-btn-carga ng-model="cargando"  ng-click="guardarDatosEmail()">{{$parent.lang[$parent.idioma]["continuar"] | capitalize}}</button>
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
					<button bt-btn-carga ng-model="cargando"  ng-click="Instalado()">{{$parent.lang[$parent.idioma]["finalizar"] | capitalize}}</button>
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
				document.cookie = "language="+idioma;
				$scope.idioma = idioma;
				sessionStorage.setItem("idioma",idioma);
			};
			$scope.paso = 1;
			$scope.config = {
				db:{
					dbname:"<?php echo $db["database"]; ?>",
					user:"<?php echo $db["username"]; ?>",
					pass:"<?php echo $db["password"] ?>",
					host:"<?php echo $db["hostname"]; ?>"
				},
				email:{
					host:"smtp.googlemail.com",
					port:465,
					user:"usuario@gmail.com",
					pass:"contraseña",
					crypto:"ssl",
					protocol:"smtp"
					
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
			};
			$scope.comprobarDB = function(){
				$scope.dbconfig.$setSubmitted(true);
				if($scope.dbconfig.$valid){
					$scope.cargando = true;
					$http({
						url:"/Instalador/ComprobarDB",
						data:$.param($scope.config.db),
						method:"POST",
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					})
					.then(function(respuesta){
						$scope.cargando = false;
						EscribirConfDB();
					},function(error){
						$scope.cargando = false;
						$scope.error_conexion = true;
					})
				}
			};
			$scope.probarDatosEmail = function(){
				$scope.enviarEmail.$setSubmitted(true);
						if($scope.enviarEmail.$valid){
							$scope.cargando = true;
							$http({
								url:"/Instalador/ProbarDatosEmail",
								method:"POST",
								data:$.param($scope.config.email),
								headers: {'Content-Type': 'application/x-www-form-urlencoded'}
							}).then(function(respuesta){
									$scope.cargando = false;
							},
							function(error){
								$scope.cargando = false;
							});
						}
			};
			$scope.guardarDatosEmail = function(){
				$scope.emailForm.$setSubmitted(true);
				if($scope.emailForm.$valid){
					$scope.cargando = true;
					$http({
						url:"/Instalador/GuardarDatosEmail",
						method:"POST",
						data:$.param($scope.config.email),
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).then(function(respuesta){
						$scope.cargando = false;
						$scope.paso = 6;
					},
					function(error){
						$scope.cargando = false;
						
					});
				}
			};
			$scope.crearDB = function(){
				$scope.cargando = true;
				$http({
						url:"/Migraciones"
					})
					.then(function(respuesta){
						$scope.cargando = false;
						$scope.creado = true;
					},function(error){
						$scope.cargando = false;
					})
			};
			
			$scope.insertarDB = function(){
				$scope.cargando = true;
				$http({
					url:"/Instalador/GenerarDatosPrueba"
				})
				.then(function(respuesta){
					$scope.cargando = false;
					$scope.paso = 5;
					$scope.insertado = true;
				},function(error){
					$scope.cargando = false;
				});
			};
			
			$scope.comprobarDBExistente = function(){
				$scope.cargando = true;
				$http({
						url:"/Instalador/ComprobarDBExistente"
					})
					.then(function(respuesta){
						$scope.cargando = false;
						$scope.paso = 4;
					},function(error){
						$scope.cargando = false;
					})
			};
			function EscribirConfDB(){
				$scope.cargando = true;
				$http({
						url:"/Instalador/EscribirConfDB",
						data:$.param($scope.config.db),
						method:"POST",
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					})
					.then(function(respuesta){
						$scope.cargando = false;
						$scope.paso = 4;
					},function(error){
						$scope.cargando = false;
						$scope.texto = error.data;
						$scope.paso = 3;
					})
			}
			
			$scope.Instalado = function(){
				$scope.cargando = true;
				$http({
					url:"/Instalador/Instalado",	
				})
				.then(
					function(respuesta){
					window.location = "/Login";
					},
					function(error){
						$scope.cargando = false;
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
}).directive("btBtnCarga",function(){
	return{
		restrict:"A",
		require:"ngModel",
		scope:{
			cargando:"=ngModel"
		},
		template:function(e,a){
			var nCuadros = a.btNCuadros || 8;
			var cuadros = "<div class='contenedor-texto'>"+e.html()+"</div><div class='contenedor-cuadros'>";
			for(var i = 0; i < nCuadros ; i++){
				cuadros += "<div style='animation-delay:"+(0.2+(0.2*i))+"s'>&nbsp;</div>";
			}
			return cuadros + "</div>";
		},
		link:function(s,e,a,m){
			console.log("Ejecutando");
			m.$render = function(){
				console.log("Modelo cambiado");
				if(s.cargando){
					e.addClass("cargando");
				}else{
					e.removeClass("cargando");
				}
			};
		}
	}
});
	</script>