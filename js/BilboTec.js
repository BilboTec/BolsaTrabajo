angular.module("BilboTec.ui",[]);
angular.module("BilboTec",["BilboTec.ui"])
.controller("formularioLoginController",["$scope","$http",function($scope,$http){
	$scope.alta = function(){
		s = $scope;
		
		debugger;
	};
}])
.controller("idiomaController", ["$scope","$http",function($scope,$http){
	$scope.cambiarIdioma = function(idioma){
	$http.get("/Idioma/cambiar/" + idioma).then(function(respuesta){
		window.location = window.location;
	}, function(error){
		
	});
	};
}]);
