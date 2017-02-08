<form name="formPerfil" ng-controller="loginCambiarClaveController" ng-init='identificador=<?php echo json_encode($identificador); ?>'>
<fieldset>
	<div bt-input-label bt-id="nuevaclave" ng-required="true" name="nuevaclave" bt-label="'<?php echo ucfirst($idioma("clave_nueva")); ?>'" bt-model="nuevaclave" type="password"></div>
	
	<div  class="error_validacion" ng-show="(formPerfil.$submitted || formPerfil.nuevaclave.$touched) && formPerfil.nuevaclave.$invalid"><?php printf($idioma("required"),$idioma("clave_nueva")); ?></div>

	<div bt-input-label bt-id="repetirclave" ng-required="true" name="repetirclave" bt-label="'<?php echo ucfirst($idioma("repetir_clave")); ?>'" bt-model="repetirclave" type="password"></div>

	<div class="error_validacion" ng-show="(formPerfil.$submitted || formPerfil.repetirclave.$touched) && formPerfil.repetirclave.$invalid"><?php printf($idioma("required"),$idioma("repetir_clave")); ?></div>

	<span class="btn btn-tipo" ng-click="cambiarClave()"><?php echo ucfirst($idioma("cambiar")); ?></span>
	<a href="#!/"><?php echo ucfirst($idioma("volver")); ?></a>

	<div bt-window="ventana"></div>

</fieldset>
</form>
<script>
	angular.module("BilboTec").controller("loginCambiarClaveController", ["$http", "$scope", function($http, $scope){
		$scope.cambiarClave = function(){
			var controlador = angular.element("input[name='repetirclave']").controller("ngModel");
			controlador.$validators.clave = function(clave2){
				return clave2 !== $scope.clave;
			};
			if($scope.formPerfil.$valid){
				$http({
					url:"/Login/CambiarClave",
					method: "POST",
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data: $.param({
						identificador: $scope.identificador,
						claveNueva: $scope.nuevaclave,
						repetirClave: $scope.repetirclave
					})
					})
					.then(
						function(respuesta){
							$scope.ventana.alerta("clave_cambiada", "clave_cambiada_cuerpo", function(){
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

