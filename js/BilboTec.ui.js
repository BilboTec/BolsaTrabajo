angular.module("BilboTec.ui")
.filter("capitalize",function(){
    return function(string){
        if(typeof string === "undefined"){
            return;
        }
        return string.substr(0,1).toUpperCase() + string.substr(1);
    }
})
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
                scope.btWindow.establecerBotones([{
                    accion:function(){
                        scope.btWindow.cerrar();
                    },
                    texto:"aceptar"
                }]);
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
                                var mensaje = error.data?error.data.data?error.data.data:error.data:JSON.stringify(error);
                                mostrar_error(mensaje);
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
                        var mensaje = error.data?error.data.data?error.data.data:error.data:JSON.stringify(error);
                        mostrar_error(mensaje);
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
                    var mensaje = error.data?error.data.data?error.data.data:error.data:JSON.stringify(error);
                    mostrar_error(mensaje);
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
                            var mensaje = error.data?error.data.data?error.data.data:error.data:JSON.stringify(error);
                            mostrar_error(mensaje);
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
                scope.btWindow.establecerTitulo("confirmar_eliminar_titulo");
                scope.btWindow.establecerContenido("confirmar_eliminar");
                scope.btWindow.establecerBotones([
                    {
                        accion:function(){
                            scope.cargando = true;
                            if(scope.configuracion.eliminar.url){
                                $http({
                                    url:scope.configuracion.eliminar.url,
                                    method:scope.configuracion.eliminar.type||"POST",
                                    data:$.param({elem:scope.filas[fila]}),
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                    }).then(function(respuesta){
                                        scope.filas.splice(fila,1);
                                        scope.cargando = false;
                                    },function(error){
                                        var mensaje = error.data?error.data.data?error.data.data:error.data:JSON.stringify(error);
                                        mostrar_error(mensaje);
                                        scope.cargando = false;
                                    });
                            }else{
                                    scope.filas.splice(fila,1);
                            }
                            scope.btWindow.cerrar();
                            },
                            texto:"si"
                    },{   
                        accion:function(){
                            scope.btWindow.cerrar();
                        },
                        texto:"no"
                    }
                ]);
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
        link:function(scope,e,a,ngModel){
            function cerrarSiClickFuera(evt){
                if(evt.target != e && e.has(evt.target).length === 0 ){
                    scope.$apply(function(){
                        scope.abierto = false;
                    });
                }
            }
            scope.abrir = function(){
                scope.abierto = true;
            };
            scope.cerrar = function(){
                scope.abierto = false;
            };
            angular.element(document).on("click",cerrarSiClickFuera);
            scope.$on("$destroy",function(){
                angular.element(document).off(cerrarSiClickFuera);
            })
            //Formato en el que se escribirá la fecha
            scope.formato = a.btFormato || "dd/mm/yyyy";
            //Elemento editable en el que se encuentra la fecha
            var texto = e.find("#texto")[0];
            //Función para mostrar la fecha
            ngModel.$render = function(){
                var strFecha = scope.valor;
                if(typeof strFecha === "undefined" || strFecha === null || !strFecha){
                    texto.innerHTML = ""
                }else{
                    var formatos = scope.formato.split("/");
                    var elementos = strFecha.split("/");
                    if(elementos.length !== formatos.length){
                        return;
                    }else{
                        var fecha = {
                            "mm":elementos[0],
                            "dd":elementos[1],
                            "yyyy":elementos[2]
                        };
                        strFecha = "";
                        for(var i = 0; i < formatos.length; i++){
                            strFecha += (i!==0?"/":"") + fecha[formatos[i]];
                        }
                        texto.innerHTML = strFecha;
                    }
                }
            }
            //Cuando el elemento editable pierda foco se considera que el control ha sido tocado
            angular.element(texto).on("blur",function(){
                scope.$apply(function(){
                    ngModel.$setTouched(true);
                });
            });
            //Cada vez que se detecte un keyup en el elemento editable se intenta leer la fecha y se establece
            //su validez
            angular.element(texto).on("keyup",function(){
                ngModel.$setDirty(true);
                var strFecha = texto.innerHTML;
                if(strFecha===""){
                    scope.$apply(function(){
                        ngModel.$setViewValue(null);
                        ngModel.$setValidity("required",false);
                    });
                    return;
                }
                var formatos = scope.formato.split("/");
                var elementos = strFecha.split("/");
                if(formatos.length !== elementos.length){
                    return;
                }
                var fecha = {};
                for(var i = 0; i < formatos.length; i++){
                    fecha[formatos[i]] = elementos[i];
                }
                fecha = fecha["mm"]+"/"+fecha["dd"]+"/"+fecha["yyyy"];
                var date = new Date(fecha);
                if(date == "Invalid Date"){
                    scope.$apply(function(){
                        ngModel.$setViewValue(fecha);
                        ngModel.$setValidity("required",true);
                        ngModel.$setValidity("date",false);
                    });
                }else{
                    scope.$apply(function(){
                        ngModel.$setViewValue(fecha);
                        ngModel.$setValidity("required",true);
                        ngModel.$setValidity("date",true);
                    });
                }
            });
            var date = new Date();
            scope.anio = date.getFullYear();
            scope.mes = date.getMonth();
            scope.meses = ["cal_jan","cal_feb","cal_mar","cal_may","cal_apr","cal_jun","cal_jul","cal_aug","cal_sep","cal_oct","cal_nov","cal_dec"];
            scope.diasSemana = ["cal_mo","cal_tu","cal_we","cal_th","cal_fr","cal_sa","cal_su"];
            scope.calcularMes = function(){
                var date = new Date(scope.anio,scope.mes,1);
                var valorFecha = new Date(scope.valor);
                //Si no empieza en lunes
                while(date.getDay()!==1){
                    date.setDate(date.getDate()-1);
                }
                scope.semanas = [];
                do{
                    var semana = [];
                    while(date.getDay()!==0){
                        semana.push({"dd":date.getDate(),"mm":date.getMonth()+1,"yyyy":date.getFullYear(),
                            activo:date.getFullYear() === valorFecha.getFullYear() && date.getMonth() === valorFecha.getMonth()
                            && date.getDate() === valorFecha.getDate()});
                        date.setDate(date.getDate()+1);
                    }
                    semana.push({"dd":date.getDate(),"mm":date.getMonth()+1,"yyyy":date.getFullYear()});
                    date.setDate(date.getDate()+1);
                    scope.semanas.push(semana);
                }while(date.getMonth()<=scope.mes && scope.anio >= date.getFullYear());
            };
            scope.calcularMes();
            scope.cambiarMes = function(cambio){
                var mes = scope.mes + cambio;
                while(mes<0){
                    mes+=12;
                    scope.anio-=1;
                }
                while(mes>11){
                    mes-=12;
                    scope.anio+=1;
                }
                scope.mes = mes;
                scope.calcularMes();
            };
            scope.establecerFecha = function(dia){
                scope.valor = dia["mm"] + "/" + dia["dd"] + "/" + dia["yyyy"];
                scope.cerrar();
            };
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
            scope.estlecerUrl = function(url){
                scope.ulr= url;
            };
            scope.establecerContenido = function(contenido){
                scope.contenido = contenido;
                scope.url = false;
            };
            scope.establecerUrl = function(url){
                scope.url = url;
            }
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
                establecerUrl:scope.establecerUrl,
                establecerBotones:scope.establecerBotones,
                establecerUrl:scope.establecerUrl
            };
        }
    }
}])
.directive("btImageUploader",function(){
    return {
        restrict: "A",
        scope:{
            imagen:"=ngModel"
        },  
        templateUrl:"/Plantillas/Get/btImageUploader",
        link:function(scope,elem,attr){
            var name = attr.btName;
            if(typeof name !== "undefined"){
                elem.find("input[type='hidden']").attr("name",name);
            }
            scope.offset = {
                x:0,y:0
            };
            scope.$render = function(){
            	var imagen = new Image();
            	imagen.onload = function(){
            		var scale = scope.scale;
                            canvas.drawImage(imagen,scope.offset.x+(imagen.width*(scale/100))*0,
                                scope.offset.y+(imagen.height*(scale/100))*0,scope.offset.x+imagen.width*(scale/100),
                                scope.offset.y+imagen.height*(scale/100));
                            scope.imagen = canvasElement.toDataURL();
                            scope.$apply(function(){scope.size = (scope.imagen.length/1024).toFixed(2)+"KB"});
            	};
            	
            	imagen.src = scope.imagen;
            };
            scope.scale = 100;
            var canvasElement = elem.find("canvas")[0];
            canvasElement.width = 100;
            canvasElement.height = 127;
            var canvas = canvasElement.getContext("2d");
            var inputImagen = elem.find("input[type='file']")[0];
            scope.imagenSeleccionada = function(){
                canvas.fillStyle = "#000000";
                canvas.fillRect(0,0,canvasElement.width,canvasElement.height);
                var archivo = inputImagen.files[0];
                if(typeof archivo !== "undefined"){
                    var fileReader = new FileReader();
                    fileReader.onload = function(event){
                        var imagen = new Image();
                        imagen.onload = function(event){
                            var scale = scope.scale;
                            canvas.drawImage(imagen,scope.offset.x+(imagen.width*(scale/100))*0,
                                scope.offset.y+(imagen.height*(scale/100))*0,scope.offset.x+imagen.width*(scale/100),
                                scope.offset.y+imagen.height*(scale/100));
                            scope.imagen = canvasElement.toDataURL();
                            scope.$apply(function(){scope.size = (scope.imagen.length/1024).toFixed(2)+"KB"});
                        };
                        imagen.src = fileReader.result;
                    };
                    fileReader.readAsDataURL(archivo);
                }
            };
            angular.element(inputImagen).on("change",scope.imagenSeleccionada);
        }
    };
})
.directive("btEditor",function(){
    return {
        restrict:"A",
        require:"?ngModel",
        scope:{
            btEditor:"=",
            valor:"=ngModel"
        },
        templateUrl:"/Plantillas/Get/btEditor",
        link:function(scope,el,at,ngModel){
            if(at.btName){
                el.find("input[type='hidden']").attr("name",at.btName);
            }
        
            if(ngModel){
                ngModel.$render = function(){
                    if(typeof scope.valor !== "undefined" && scope.valor !== null) {
                        doc.body.innerHTML = scope.valor;
                    }
                };
            }
            scope.fuentes = [
                "Georgia", "Book Antiqua","Times New Roman", "Arial", "Arial Black","Comic Sans MS",
                "Impact", "Lucida Sans Unicode", "Tahoma", "Helvetica", "Verdana", "Courier", "Monaco"

            ];
            var doc = el.find("iframe")[0].contentDocument;
            
            doc.designMode = "on";
            scope.comando = function(tipo,valor){
                doc.execCommand(tipo,true,valor);
                scope.actualizar();
            };
            scope.actualizar = function(){
                scope.valor = doc.body.innerHTML;
            };
            doc.onkeyup = function(){
                ngModel.$setViewValue(doc.body.innerHTML);
            }
            scope.link = function(){
                var ventana = scope.ventana;
                ventana.establecerTitulo("nuevo_link");
                ventana.establecerUrl("/Plantillas/Editor/editorEstandar");
                ventana.establecerBotones([
                    {
                        texto:"aceptar",
                        accion:function(){
                            var url = el.find("[bt-window] input").val();
                            scope.comando("createLink",url);
                            ventana.cerrar();
                        }
                    },{
                        texto:"cancelar",
                        accion:function(){
                            ventana.cerrar();
                        }
                    }
                ]);
                ventana.abrir();
                ventana.centrar();
            };
        }
    }
}).
directive("btAutoComplete",["$http",function($http){
    return{
        restrict: "A"
        
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
})

.directive("btExperiencia",["$http", function($http){
	return{
		restrict: "A",
		require: "ngModel",
		scope:{
			alumno: "=ngModel"
		},
		templateUrl: "/plantillas/Get/btExperiencia",
		link: function(scope, elemento, atributos, ngModel){
			scope.editar = "/plantillas/Get/btEditarExperiencia";
			scope.vista = "/plantillas/Get/btMostrarExperiencia";
			scope.$on("cancelar_edicion", function(){
				scope.indiceEdicion = -1;
				scope.insertando = false;
			})
			scope.$on("editar_experiencia", function(evento, args){
				scope.indiceEdicion = args.indice;
			});
			scope.insertar = function(){
				scope.indiceEdicion = -1;
				scope.insertando = true;
			};
			scope.$on("aplicar_edicion_experiencia",function(avento,args){
				if(typeof args.nuevo !== "undefined" && args.nuevo){
					scope.alumno.experiencias.push(args.experiencia);
				}else{
					scope.alumno.experiencias[scope.indiceEdicion] = args.experiencia;
				}
				scope.indiceEdicion = -1;
				scope.insertando = false;
			});
			ngModel.$render = function(){
				if(typeof scope.alumno === "undefined"){
					return;
				}
				$http({
					url: "/api/Experiencias/Get/" + scope.alumno.id_alumno
				})
				.then(
					function(respuesta){
						scope.alumno.experiencias = respuesta.data.data;
				},
					function(error){
						alert(error.data?error.data:error);
					})
			}
		}
	}
}])

.controller("btEditarExperiencia",["$scope","$http", function($scope,$http){
			$scope.vista = angular.copy($scope.experiencia);
			$scope.onTrabajandoActualmente_change = function(){
				if($scope.experiencia.trabajando_actualmente){
					$scope.experiencia.fecha_fin = null;
				}
			};
			$scope.cancelar = function(){
				$scope.$emit("cancelar_edicion");
			};
			$scope.guardar = function(){
				var config ={
					url: "/api/Experiencias/Update",
					method: "POST",
					data: $.param({
						viejo:$scope.experiencia,
						nuevo:$scope.vista
						}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				};
				if(typeof $scope.nuevo !== "undefined" && $scope.nuevo){
					config.url = "/api/Experiencias/Insert";
					config.data = $.param($scope.vista);
				}
				$http(config)
				.then(
					function(respuesta){
						var args = {experiencia:respuesta.data[0]};
						if(typeof $scope.nuevo !== "undefined" && $scope.nuevo){
							args.nuevo = true;
						}
						$scope.$emit("aplicar_edicion_experiencia",args);
					}
				)
			}
		
}])

.controller("btMostrarExperiencia", function($scope){
	$scope.editar = function(){
		$scope.$emit("editar_experiencia", {
			indice:$scope.$index
		});
	};
})
.directive("btFormacionAcademica",["$http",function(){
	return{
		scope:{
			alumno:"=ngModel"
			},
			templateUrl:"/plantillas/Get/btFormacionAcademica",
			link:function(scope){
			scope.editar = "/plantillas/Get/btEditarFormacionAcademica?coleccion[]=tipo_titulacion&coleccion[]=oferta_formativa";
			scope.vista = "/plantillas/Get/btMostrarFormacionAcademica";
			scope.$on("cancelar_edicion", function(){
				scope.indiceEdicion = -1;
				scope.insertando = false;
			})
			scope.$on("editar_formacion", function(evento, args){
				scope.indiceEdicion = args.indice;
			});
			scope.insertar = function(){
                scope.vista = {};
				scope.indiceEdicion = -1;
				scope.insertando = true;
			};
			scope.$on("aplicar_edicion_formacion",function(avento,args){
				if(typeof args.nuevo !== "undefined" && args.nuevo){
					scope.alumno.experiencias.push(args.experiencia);
				}else{
					scope.alumno.experiencias[scope.indiceEdicion] = args.experiencia;
				}
				scope.indiceEdicion = -1;
				scope.insertando = false;
			});
				scope.$render = function(){
					$http({
						url:"/api/FormacionAcademica/Get/" + scope.alumno.id_alumno
					})
					.then(function(respuesta){
						scope.alumno.formaciones = respuesta.data.data;
					},function(error){
						
					})
				};
			}
		}
}])
.controller("btEditarFormacionAcademica",["$scope","$http", function($scope,$http){
			$scope.vista = angular.copy($scope.formacion);
			$scope.onCursando_change = function(){
				if($scope.formacion.cursando){
					$scope.formacion.fecha_fin = null;
				}
			};
			$scope.cancelar = function(){
				$scope.$emit("cancelar_edicion");
			};
			$scope.guardar = function(){
				var config ={
					url: "/api/FormacionAcademica/Update",
					method: "POST",
					data: $.param({
						viejo:$scope.experiencia,
						nuevo:$scope.vista
						}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				};
				if(typeof $scope.nuevo !== "undefined" && $scope.nuevo){
					config.url = "/api/FormacionAcademica/Insert";
					config.data = $.param($scope.vista);
				}
				$http(config)
				.then(
					function(respuesta){
						var args = {experiencia:respuesta.data[0]};
						if(typeof $scope.nuevo !== "undefined" && $scope.nuevo){
							args.nuevo = true;
						}
						$scope.$emit("aplicar_edicion_experiencia",args);
					}
				)
			}

            $scope.cargarOfertas = function(){
                $http({url:"/api/OfertaFormativa/GetByTipo/" +$scope.formacion.id_tipo_titulacion})
                .then(
                    function(respuesta){
                        $scope.ofertas = respuesta.data.data;
                    },
                    function(error){

                    }
                    )
            }
		
}])

.controller("perfilAlumnoDatosPersonalesController", ["$http", "$scope", function($http, $scope){
    $scope.cargarLocalidades = function(){
        $http({
            url:"/api/Localidades/GetDeProvincia/" + $scope.id_provincia
        })
        .then(
            function(respuesta){
                $scope.localidades = respuesta.data;
            },
            function(error){
                alert(error.data?error.data:error);
            }
            )
    }
	$scope.editar = function(){
		$scope.vista = angular.copy($scope.alumno);
        $scope.cargarLocalidades();
		$scope.editando = true;
        $scope.imagen_copia = angular.copy($scope.imagen);
	}
	
	$scope.cancelar = function(){
		$scope.vista= {};
		$scope.editando = false;
	}
	
	$scope.guardar = function(){
		$http({url: "/api/Alumnos/GuardarPerfil", 
				method: "POST", 
				data: $.param($scope.vista),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					$scope.cancelar();
					$scope.alumno = respuesta.data;
				},
				function(error){
					alert(error.data?error.data:error);
				}
				)
        $http({url: "/api/Alumnos/GuardarImagen", 
                method: "POST", 
                data: $.param({imagen:$scope.imagen_copia}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(
                function(respuesta){
                   $scope.imagen = respuesta.data.imagen;

                },
                function(error){
                    alert(error.data?error.data:error);
                }
                )
	}
}])
.controller("perfilAlumnoOtrosDatosController", ["$http", "$scope", function($http, $scope){
   
    $scope.editar = function(){
        $scope.vista = angular.copy($scope.alumno);
        $scope.cargarLocalidades();
        $scope.editando = true;
        $scope.imagen_copia = angular.copy($scope.imagen);
    }
    
    $scope.cancelar = function(){
        $scope.vista= {};
        $scope.editando = false;
    }
    
    $scope.guardar = function(){
        $http({url: "/api/Alumnos/GuardarPerfil", 
                method: "POST", 
                data: $.param($scope.vista),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(
                function(respuesta){
                    $scope.cancelar();
                    $scope.alumno = respuesta.data;
                },
                function(error){
                    alert(error.data?error.data:error);
                }
                )
    }
}]);