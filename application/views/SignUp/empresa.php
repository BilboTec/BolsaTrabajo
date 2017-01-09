<form method="POST" ng-controller="solicitudController" name="solicitud" class="form-solicitud-empresa" novalidate>
	<fieldset>
			<legend><?php echo strtoupper($idioma('iniciar_sesion')); ?></legend>
			<div class="login-contenedor">
				<div class="grupo-form">
					<div bt-input-label bt-id="nombre" ng-required="true" name="nombre" type="text" bt-label="'nombre' | btLocale | capitalize" bt-model="nombre"></div>
					<?php echo form_error("nombre",'<div class="error-validacion" ng-hide="solicitud.nombre.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(solicitud.$submitted || solicitud.nombre.$touched) && solicitud.nombre.$error.required"><?php printf($idioma("required"),$idioma("nombre")); ?></div>
				</div>
				<div class="grupo-form">
				<input type="hidden" name="tipo" value="{{tipo}}" />
					<div bt-input-label bt-id="email" ng-required="true" name="email" type="email" bt-label="'<?php echo ucfirst($idioma('email')); ?>'" bt-model="email"></div>
					<?php echo form_error("email",'<div class="error-validacion" ng-hide="solicitud.email.$valid">',"</div>"); ?>
					<div class="error-validacion" ng-show="(solicitud.$submitted || solicitud.email.$touched) && solicitud.email.$error.email"><?php printf($idioma("valid_email"),$idioma("email")); ?></div>
					<div class="error-validacion" ng-show="(solicitud.$submitted || solicitud.email.$touched) && solicitud.email.$error.required"><?php printf($idioma("required"),$idioma("email")); ?></div>
				</div>
				<button type="button" class="btn btn-tipo" ng-click="solicitar()"><?php echo ucfirst($idioma('registrarse')); ?></button>
			</div>
		</fieldset>
</form>
<script>
		angular.module("BilboTec").controller("solicitudController",["$scope","$http",function($scope,$http){
			$scope.tipo = 2;
			$scope.solicitar = function(){
				$scope.solicitud.$setSubmitted(true)
				if($scope.solicitud.$valid){
					$http({
						url:"/SignUp/ConfirmarEmpresa",
						method: "POST",
						data: $.param({nombre:$scope.nombre,email:$scope.email}),
						headers: {'Content-Type': 'application/x-www-form-urlencoded'}
					}).then(function(respuesta){
						alert("Exito");
					},function(error){
						alert("Error");
					});
				}
			};
		}])
</script>