
<div ng-controller="testVentanaController">
<div bt-window="btWindow"></div>
<label>Contenido<input type="text" ng-model="texto"></label>
<button ng-click="abrirModal()">Abrir Modal</button>
<button ng-click="abrir()">Abrir ventana</button>
<button ng-click="cerrar()">Cerrar Ventana</button>
<button ng-click="centrar()">Centrar</button>
</div>
<script>
	angular.module("BilboTec").controller("testVentanaController",function($scope){
		$scope.texto = "Introduce el contenido de la ventana"
		$scope.abrir = function(){
			$scope.btWindow.establecerTitulo("Test");
			$scope.btWindow.establecerBotones({
				"Aceptar":function(){
					$scope.btWindow.cerrar();
				},
				"Cancelar":function(){
					$scope.btWindow.cerrar();
				}
			});
			$scope.btWindow.establecerContenido($scope.texto);
			$scope.btWindow.abrir();
		};
		$scope.cerrar = function(){
			$scope.btWindow.cerrar();
		};
		$scope.centrar = function(){
			$scope.btWindow.centrar();
		};
		$scope.abrirModal = function(){
			$scope.btWindow.establecerTitulo("Test");
			$scope.btWindow.establecerModal(true);
			$scope.btWindow.establecerBotones({
				"Aceptar":function(){
					$scope.btWindow.cerrar();
				},
				"Cancelar":function(){
					$scope.btWindow.cerrar();
				}
			});
			$scope.btWindow.establecerContenido($scope.texto);
			$scope.btWindow.abrir();
		};
	});
</script>