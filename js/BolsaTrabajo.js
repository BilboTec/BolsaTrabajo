angular.module("BolsaTrabajo.ui",[]).directive("btInputLabel",function(){
	return{
		restrict:"A",
		require:"ngModel",
		scope:{
			valor:"=ngModel",
		},
		template:"<label>{{ label }}</label><input type='text'ng-model='value'/>",
		link:function(scope,elem,attr){
			scope.label = attr.texto;
		}
	};
});
angular.module("BolsaTrabajo",["BolsaTrabajo.ui"])
.controller("formularioLoginController",["$scope","$http",function($scope,$http){
}]);
