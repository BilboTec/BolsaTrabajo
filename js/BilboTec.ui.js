angular.module("BilboTec.ui")
.directive("btInputLabel",function(){
    return{
        restrict: "A",
        scope:{
            valor:"=btModel",
            label:"=btLabel",
            required:"=ngRequired",
            leer:"=leer"
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
            configuracion:"=btConfig",
            btSetConfig:"="
        },
        templateUrl:"/Plantillas/Get/btTabla",
        link:function(scope,elem,attr){
            scope.editandoFila = -1;
            scope.editar = function(fila){
                scope.editandoFila = fila;
                scope.edit = angular.copy(scope.filas[fila]);
            };
            scope.crearControlesPaginacion = function(){
                var botonInicial = scope.configuracion.paginacion.pagina;
                while(botonInicial>1 && botonInicial > (scope.configuracion.paginacion.pagina
                - scope.configuracion.paginacion.nBotones/2)){
                    botonInicial--;
                }
                var botones = [];
               for(var i = 0; i < scope.configuracion.paginacion.nBotones; i++){
                    botones.push(botonInicial++);
               }
                return botones;
            };
            scope.aplicar = function(){
                var data = scope.configuracion.actualizar.data?
                        scope.configuracion.actualizar.data():{};
                        data.viejo = scope.filas[scope.editandoFila];
                        data.nuevo = scope.edit;
                if(scope.configuracion.actualizar.url){
                    $http({
                        url:scope.configuracion.actualizar.url,
                        method:scope.configuracion.type||"POST",
                       	headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data:$.param(data)
                    }).then(function(respuesta){
                            scope.filas[scope.editandoFila] = respuesta.data[0];
                            scope.editandoFila = -1;
                            scope.edit = {};
                       },
                        function(error){
                        	alert(error.data?error.data:JSON.stringify(error));
                        });
                }else{
                    scope.filas[scope.editandoFila] = scope.edit;
                    scope.editandoFila = -1;
                    scope.edit = {};
                }
            };
            scope.leer = function(){
                scope.filas= [];
                if(scope.configuracion.leer.url){
                    var datos = scope.configuracion.leer.data?scope.configuracion.leer.data():{};
                    datos.resultadosPorPagina = scope.configuracion.paginacion.pageSizes.seleccionado.valor;
                    $http({
                        url:scope.configuracion.leer.url,
                        method :scope.configuracion.leer.method ||"GET",
                        params:datos
                    }).then(function(respuesta){
                        scope.filas = respuesta.data;
                    },function(error){
                        alert(response.data?response.data:JSON.stringify(response));
                    });
                }
            };
            scope.cancelar = function(){
                scope.edit = {};
                scope.editandoFila = -1;
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
                        url:scope.configuracion.insertar.url,
                        method:scope.configuracion.insertar.type||"POST",
                        data:$.param(scope.edit),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).then(function(respuesta){
                        scope.filas.push(respuesta.data[0]);
                        scope.edit = {};
                        scope.editandoFila = -1;
                        scope.mostrarInsertar = false;
                    },function(error){
                        alert(error.data?error.data:JSON.stringify(error));
                    });
                }else{
                    scope.filas.push(angular.copy(scope.edit));
                    scope.mostrarInsertar = false;
                }
            };
            scope.eliminar = function(fila){
                var confirmar = confirm("¿Seguro que desea eliminar la fila?");
                if(confirmar){
                    if(scope.configuracion.eliminar.url){
                        $http({
                            url:scope.configuracion.eliminar.url,
                            method:scope.configuracion.eliminar.type||"POST",
                            data:$.param({elem:scope.filas[fila]}),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function(respuesta){
                            scope.filas.splice(fila,1);
                        },function(error){
                            alert(error.data?error.data:JSON.stringify(error));
                        });
                    }else{
                        scope.filas.splice(fila,1);
                    }
                }
            };
            scope.ordenar = function(columna){
                scope.configuracion.direccion=scope.configuracion.orden===columna?!scope.configuracion.direccion:false;
                scope.configuracion.orden = columna;

            };
            scope.btSetConfig = function(configuracion){
            	scope.configuracion = configuracion;
            	scope.leer();
            };
            if(scope.configuracion.leer){
                scope.leer();
            }
        }

    };
}]);