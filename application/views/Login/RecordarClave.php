<div class="contenedor-perfil" ng-controller="recordarClaveController">
	<fieldset>
		<legend> <?php echo mb_strtoupper($idioma("cambiar_clave")); ?></legend>
	<div class="grupo">
		<div class="grupo sin-margen">
			<label for="email"><?php echo ucfirst($idioma("email")); ?></label>
			<input type="email" id="email" ng-model="email" ng-required="true"/>
		</div>
		<span class="btn btn-tipo" ng-click="enviar()"><?php echo ucfirst($idioma("enviar")); ?></span>
	</div>
	</fieldset>
	<div bt-window="ventana"></div>
</div>

<script>
	angular.module("BilboTec").controller("recordarClaveController", ["$http", "$scope", function($http, $scope){

		$scope.enviar = function(){
			var inputEmail = angular.element("#email").controller("ngModel");

			if(inputEmail.$valid){
				$http(
					{
						url:"/Login/EnviarIdentificador",
						params:{
							email:$scope.email
						}
					}
				)
				.then(
					function(respuesta){
						$scope.ventana.alerta("exito","alerta_recuperar_clave",function(){
							window.location = "/Login";
						})
					},
					function(error){
						
					}
				)
			}
		}
	}])
</script>