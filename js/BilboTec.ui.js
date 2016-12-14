angular.module("BilboTec.ui")
.directive("btInputLabel",function(){
    return{
        restrict: "A",
        scope:{
            valor:"=btModel",
            label:"=btLabel",
            required:"=ngRequired"
        },
        templateUrl:function(elem,attrs){
            var url = "/Plantillas/Get/btInputLabel?type="
                +(attrs.type?attrs.type:"text");
            if(attrs.name){
                url+="&name="+attrs.name;
            }
            if(attrs.btId){
            	url += "&id="+attrs.btId;
            }
            return url;

        },
        link:function(scope,elem,attr){
        	scope.vacio = true;
            scope.estaVacio = function(){
            	return (typeof scope.valor === 'undefined' || scope.valor == '');
            };
        }
    };
})
.directive("btTabla",["$http",function($http){
    return {
        restrict: "A",
        require:"ngModel",
        scope:{
            filas:"=ngModel",
            configuracion:"=btConfig"
        },
        templateUrl:"Plantillas/Get/btTabla",
        link:function(scope,elem,attr){
            scope.editandoFila = -1;
            scope.editar = function(fila){
                scope.editandoFila = fila;
                scope.edit = angular.copy(scope.filas[fila]);
            };
            scope.aplicar = function(){
                if(scope.configuracion.actualizar.url){
                    $http({
                        url:scope.configuracion.actualizar.url,
                        type:scope.configuracion.type||"POST",
                        success:function(respuesta){
                            scope.filas[scope.editandoFila] = respuesta.data;
                            scope.editandoFila = -1;
                            scope.edit = {};
                        }
                    });
                }else{
                    scope.filas[scope.editandoFila] = scope.edit;
                    scope.editandoFila = -1;
                    scope.edit = {};
                }
            };
            scope.insertar = function(){
                scope.editandoFila = -1;
                scope.mostrarInsertar = true;
                scope.edit = {};
            };
            scope.cancelarInsertar = function(){
                scope.mostrarInsertar = false;
            };
            scope.aplicarInsertar = function(){
                if(scope.configuracion.insertar.url){
                    $http({
                        url:scope.configuracion.url,
                        type:scope.configuracion.type||"POST",
                        
                    });
                }else{
                    scope.filas.push(angular.copy(scope.edit));
                    scope.mostrarInsertar = false;
                }
            };
            scope.eliminar = function(fila){
                scope.filas.splice(fila,1);
            };
            scope.ordenar = function(columna){
                scope.configuracion.direccion=scope.configuracion.orden===columna?!scope.configuracion.direccion:false;
                scope.configuracion.orden = columna;

            };
        }

    }
}]);