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
            function mostrar_error(mensaje) {
                scope.btWindow.establecerTitulo("Error");
                scope.btWindow.establecerContenido(mensaje);
                scope.btWindow.establecerBotones({
                    "Aceptar":function(){
                        scope.btWindow.cerrar();
                    }
                });
                scope.btWindow.abrir();
                scope.btWindow.centrar();
            }
            scope.editar = function(fila){
                scope.mostrarInsertar = false;
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
                if(scope.validar()) {
                    scope.cargando = true;
                    var data = scope.configuracion.actualizar.data ?
                        scope.configuracion.actualizar.data() : {};
                    data.viejo = scope.filas[scope.editandoFila];
                    data.nuevo = scope.edit;
                    if (scope.configuracion.actualizar.url) {
                        $http({
                            url: scope.configuracion.actualizar.url,
                            method: scope.configuracion.type || "POST",
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            data: $.param(data)
                        }).then(function (respuesta) {
                                scope.filas[scope.editandoFila] = respuesta.data.length?respuesta.data[0]:respuesta.data;
                                scope.editandoFila = -1;
                                scope.edit = {};
                            scope.cargando = false;
                            },
                            function (error) {
                                alert(error.data ? error.data : JSON.stringify(error));
                                scope.cargando = false;
                            });
                    } else {
                        scope.filas[scope.editandoFila] = scope.edit;
                        scope.editandoFila = -1;
                        scope.edit = {};
                        scope.cargando = false;
                    }
                }
            };
            scope.cambiarPagina = function(pag){
                scope.configuracion.paginacion.pagina+=pag;
                scope.leer();
            };
            scope.irPagina = function(pag){
                scope.configuracion.paginacion.pagina = pag;
                scope.leer();
            };
            scope.leer = function(){
                scope.filas= [];
                if(scope.configuracion.leer.url){
                    scope.cargando = true;
                    var datos = scope.configuracion.leer.data?scope.configuracion.leer.data():{};
                    datos.resultadosPorPagina = scope.configuracion.paginacion.pageSizes.seleccionado.valor;
                    datos.pagina = scope.configuracion.paginacion.pagina;
                    datos.orden = scope.configuracion.orden;
                    datos.direccion = scope.configuracion.direccion?"asc":"desc";
                    $http({
                        url:scope.configuracion.leer.url,
                        method :scope.configuracion.leer.method ||"GET",
                        params:datos
                    }).then(function(respuesta){
                        scope.filas = respuesta.data.data;
                        scope.configuracion.paginacion.total =  Math.ceil(respuesta.data.total / scope.configuracion.paginacion.pageSizes.seleccionado.valor);
                        scope.cargando = false;
                    },function(error){
                        mostrar_error(error.data?error.data:JSON.stringify(error));
                        scope.cargando = false;
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
            scope.validar = function(){
                var cols = scope.configuracion.columnas;
              for(var col in cols){
                  if(cols[col].validar){
                      var validez = cols[col].validar(scope.edit[col]);
                      if(!validez.valido){
                          alert(validez.mensaje);
                          return false;
                      }
                  }
              }
                return true;
            };
            scope.leerColeccion = function(col) {
                scope.configuracion.columnas[col].coleccion = {};
                $http({
                    url: scope.configuracion.columnas[col].leer.url
                }).then(function (respuesta) {
                    for (var i in respuesta.data.data) {
                        var elemento = scope.configuracion.columnas[col].leer.crearElemento(respuesta.data.data[i]);
                        scope.configuracion.columnas[col].coleccion[elemento.clave] = elemento.valor;
                    }
                }, function (error) {
                    alert(error.data ? error.data : JSON.stringify(error));
                });
            };
            scope.leerColecciones = function(){
              if(scope.configuracion){
	              for(var columna in scope.configuracion.columnas){
	                  if(scope.configuracion.columnas[columna].leer){
	                      scope.leerColeccion(columna);
	                  }
	              }
              }
            };
            scope.aplicarInsertar = function(){
                if(scope.validar()) {
                    scope.cargando = true;
                    if (scope.configuracion.insertar.url) {
                        $http({
                            url: scope.configuracion.insertar.url,
                            method: scope.configuracion.insertar.type || "POST",
                            data: $.param(scope.edit),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (respuesta) {
                            var nuevo;
                            if(respuesta.data){
                                if(angular.isArray(respuesta.data)){
                                    nuevo = respuesta.data[0];
                                }else{
                                    nuevo = respuesta.data;
                                }  
                            }else{
                                if(angular.isArray(respuesta)){
                                    nuevo = respuesta[0];
                                }else{
                                    nuevo = respuesta;
                                }
                            }
                            scope.filas.unshift(nuevo);
                            scope.edit = {};
                            scope.editandoFila = -1;
                            scope.mostrarInsertar = false;
                            scope.cargando = false;
                            scope.cargando = false;
                        }, function (error) {
                            alert(error.data ? error.data : JSON.stringify(error));
                            scope.cargando = false;
                        });
                    } else {
                        scope.filas.unshift(angular.copy(scope.edit));
                        scope.editandoFila = -1;
                        scope.edit = {};
                        scope.mostrarInsertar = false;
                        scope.cargando = false;
                    }
                }
            };
            scope.eliminar = function(fila){             
                scope.mostrarInsertar = false;
                scope.editandoFila = -1;
                scope.edit = {};
                scope.btWindow.establecerTitulo("Confirmar Eliminar");
                scope.btWindow.establecerContenido("¿Seguro que desea eliminar la linea?");
                scope.btWindow.establecerBotones({
                    "Si":function(){
                         if(scope.configuracion.eliminar.url){
                            $http({
                                url:scope.configuracion.eliminar.url,
                                method:scope.configuracion.eliminar.type||"POST",
                                data:$.param({elem:scope.filas[fila]}),
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).then(function(respuesta){
                                scope.filas.splice(fila,1);
                            },function(error){
                                mostrar_error(error.data?error.data:JSON.stringify(error));
                            });
                        }else{
                            scope.filas.splice(fila,1);
                        }
                        scope.btWindow.cerrar();
                    },
                    "No":function(){
                        scope.btWindow.cerrar();
                    }
                });
                scope.btWindow.abrir();
                scope.btWindow.centrar();
            };
            scope.ordenar = function(columna){
                scope.mostrarInsertar = false;
                scope.editandoFila = -1;
                scope.edit = {};
                scope.configuracion.direccion=scope.configuracion.orden===columna?!scope.configuracion.direccion:false;
                scope.configuracion.orden = columna;
                scope.leer();
            };
            scope.btSetConfig = function(configuracion){
                scope.editandoFila = -1;
                scope.edit = {};
            	scope.configuracion = configuracion;
                scope.configuracion.orden = Object.keys(scope.configuracion.columnas)[0];
                scope.configuracion.direccion = true;
            	scope.leerColecciones();
            	scope.leer();
            };

                
            scope.leerColecciones();
            if(scope.configuracion && scope.configuracion.leer){
                scope.leer();
            }
        }

    };
}])
    .directive("btListaDesplegable",["$http",function($http){
        return {
            restrict:"A",
            require:"ngModel",
            scope:{
                valor:"=ngModel",
                conf:"=btConfig",
                btListaDesplegable:"="
            },
            templateUrl:"/Plantillas/Get/btListaDesplegable",
            link:function(scope,element,attr,contr){
                scope.elementos = scope.conf.elementos||[];
                scope.cargando = false;
                scope.conf = scope.conf||{};
                scope.leer = function(){
                  if(scope.conf.leer){
                      scope.cargando=true;
                      var l = scope.conf.leer;
                      var parametros = l.data?l.data():{};
                      scope.elementos = [];
                      $http({
                          url:l.url,
                          method:l.method||"GET",
                          params:parametros
                      })
                          .then(function(respuesta){
                              scope.elementos = l.set?l.set(respuesta):respuesta.data;
                              scope.cargando = false;
                          },
                          function(error){
                              alert(error.data||error);
                              scope.cargando = false;
                          });
                  }
                };
                scope.leer();
                scope.desplegado = false;
                scope.conf.clave = scope.conf.clave || function(element){ return element["clave"];};
                scope.conf.texto= scope.conf.texto||function(element){return element["texto"];};
                scope.seleccionar = function(indice){
                    scope.valor = scope.elementos[indice];
                    scope.desplegado = false;
                    contr.$setDirty(true);
                };
                scope.desplegar = function(){
                    scope.desplegado =  !scope.desplegado;
                    contr.$setTouched(true);
                };
                scope.btListaDesplegable = {
                    leer:scope.leer,
                    seleccionar:scope.seleccionar,
                    desplegar:scope.desplegar
                };
                angular.element(document).on("click",function(evt){
                    if(scope.desplegado && element.has(evt.target).length === 0){
                        scope.$apply(function(){scope.desplegado = false;});
                    }
                });
            }
        }
    }])
    .directive("btDatePicker",["$locale",function($locale){
        return {
            restrict:"A",
            require:"ngModel",
            scope:{
                valor:"=ngModel",
                conf:"=btConfig",
                btDatePicker:"="
            },
            templateUrl:"/Plantillas/Get/btDatePicker",
            link:function(scope,e,a,ctr){

            }
        };
    }])
    .directive("btWindow",["$window",function($window){
        return {
            restrict: "A",
            scope:{
                btWindow:"="
            },
            templateUrl:"/Plantillas/Get/btWindow",
            link:function(scope,el,atributo){
                var elemento = el.find(".bt-window");
                scope.visible = false;
                scope.movible = true;
                scope.titulo = "";
                scope.contenidoTexto = "";
                scope.contenidoUrl = "#";
                elemento.on("mousedown",".bt-window-titulo",function(evt){
                    if(scope.movible){
                        var offset = elemento.offset();
                        var raton = {X:evt.clientX-offset.left,Y:evt.clientY-offset.top};
                        var mover = function(evt){
                            var left = evt.clientX - raton.X;
                            var top = evt.clientY - raton.Y;
                            elemento.css("left",left+"px");
                            elemento.css("top",top+"px");
                        };
                        var wnd = angular.element($window);
                        wnd.on("mousemove",mover);
                        wnd.one("mouseup",function(){
                            wnd.off("mousemove",mover);
                        });
                    }
                });
                scope.setMovible = function(movible){
                    scope.movible = movible;
                };
                scope.abrir = function(){
                    scope.visible = true;
                };
                scope.establecerContenido = function(contenido){
                    scope.contenido = contenido;
                    scope.url = false;
                };
                scope.cerrar = function(){
                    scope.visible = false;
                };
                scope.centrar = function(){
                    elemento.css({
                        "left":$window.innerWidth/2-elemento.width()/2,
                        "top":$window.innerHeight/2-elemento.height()/2
                    });
                };
                scope.establecerTitulo = function(titulo){
                    scope.titulo = titulo;
                };
                scope.establecerBotones = function(botones){
                    scope.botones = botones;
                }
                scope.btWindow = {
                    abrir:scope.abrir,
                    cerrar:scope.cerrar,
                    centrar:scope.centrar,
                    establecerContenido:scope.establecerContenido,
                    establecerTitulo:scope.establecerTitulo,
                    establecerBotones:scope.establecerBotones
                };
            }
        }
    }]);