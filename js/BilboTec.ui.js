angular.module("BilboTec.ui")
.filter("capitalize",function(){
    return function(string){
        if(typeof string === "undefined"){
            return;
        }
        return string.substr(0,1).toUpperCase() + string.substr(1);
    };
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
                    data.vista = scope.edit;
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
                            var vista;
                            if(respuesta.data){
                                if(angular.isArray(respuesta.data)){
                                    vista = respuesta.data[0];
                                }else{
                                    vista = respuesta.data;
                                }  
                            }else{
                                if(angular.isArray(respuesta)){
                                    vista = respuesta[0];
                                }else{
                                    vista = respuesta;
                                }
                            }
                            scope.filas.unshift(vista);
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
    };
}])
.directive("btDatePicker",["$document",function($document){
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
                e.find(".desplegable").removeAttr("style");
                scope.abierto = true;
            };
            scope.cerrar = function(){
                scope.abierto = false;
            };
            $document.on("click",cerrarSiClickFuera);
            scope.$on("$destroy",function(){
                $document.off("click",cerrarSiClickFuera);
            }),
            //Formato en el que se escribirá la fecha
            scope.formato = a.btFormato || "dd-mm-yyyy";
            //Elemento editable en el que se encuentra la fecha
            var texto = e.find("#texto")[0];
            //Función para mostrar la fecha
            ngModel.$render = function(){
                var strFecha = scope.valor;
                if(typeof strFecha === "undefined" || strFecha === null || !strFecha){
                    texto.innerHTML = ""
                    ngModel.$setValidity("required",false);
                }
                else{

                    var formatos = scope.formato.split("-");
                    var elementos = strFecha.split(" ")[0].split("-");
                    if(elementos.length !== formatos.length){
                        ngModel.$setValidity("date",false);
                        return;
                    }
                    else{
                        var fecha = {
                            "mm":elementos[1],
                            "dd":elementos[2],
                            "yyyy":elementos[0]
                        };
                        strFecha = "";
                        for(var i = 0; i < formatos.length; i++){
                            strFecha += (i!==0?"-":"") + fecha[formatos[i]];
                        }
                        ngModel.$setValidity("required",true);
                        ngModel.$setValidity("date",true);
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
                if(strFecha.trim()===""){
                    scope.$apply(function(){
                        ngModel.$setViewValue(null);
                        ngModel.$setValidity("required",false);
                    });
                    return;
                }
                var formatos = scope.formato.split("-");
                var elementos = strFecha.split("-");
                if(formatos.length !== elementos.length){
                    scope.$apply(function(){
                        ngModel.$setValidity("required",true);
                        ngModel.$setValidity("date",false);
                    });
                    return;
                }
                var fecha = {};
                for(var i = 0; i < formatos.length; i++){
                    fecha[formatos[i]] = elementos[i];
                }
                fecha = fecha["yyyy"]+"-"+fecha["mm"]+"-"+fecha["dd"];
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
            scope.anios = [];
            scope.mes = date.getMonth();
            scope.meses = ["cal_jan","cal_feb","cal_mar","cal_may","cal_apr","cal_jun","cal_jul","cal_aug","cal_sep","cal_oct","cal_nov","cal_dec"];
            scope.mesesCompletos = ["cal_january","cal_february",
            "cal_march","cal_mayl","cal_april","cal_june","cal_july",
            "cal_august","cal_september","cal_october","cal_november",
            "cal_december"];
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
                scope.valor = dia["yyyy"] + "-" + dia["mm"] + "-" + dia["dd"];
                scope.cerrar();
            };
            scope.mostrarMeses = function($event){
                scope.estado = 1;
                $event.preventDefault();
                $event.stopPropagation();
            };
            scope.mostrarAnios = function($event){
                scope.anioInicio = scope.anio;
                while(scope.anioInicio%10!==0){
                    scope.anioInicio--;
                }
                scope.anioFin = scope.anio+1;
                while(scope.anioFin%10!==0){
                    scope.anioFin++;
                }
                scope.calcularAnios();
                scope.estado = 2;
                $event.preventDefault();
                $event.stopPropagation();
            };
            scope.calcularAnios = function(){
                scope.anios = [];
                for(var i = scope.anioInicio; i <= scope.anioFin; i++){
                    scope.anios.push(i);
                }
            };
            scope.seleccionarMes = function($event,indice){
                scope.mes = indice;
                scope.calcularMes();
                scope.estado = 0;
                $event.preventDefault();
                $event.stopPropagation();
            };
            scope.cambiarAnio = function ($event,cambio){
                scope.anio+=cambio;
                $event.preventDefault();
                $event.stopPropagation();
            };
            scope.cambiarAniosMostrados = function($event,cambio){
                scope.anioFin +=cambio;
                scope.anioInicio +=cambio;
                scope.calcularAnios();
                $event.preventDefault();
                $event.stopPropagation();
            };
            scope.establecerAnio = function($event,anio){
                scope.anio = anio;
                scope.estado = 1;
                $event.preventDefault();
                $event.stopPropagation();
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
                        elemento.css("right", "auto");
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
                el.find(".bt-window-wrapper").removeAttr("style");
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
                    "left": "auto",
                    "right":0,
                    "top":0

                });
            };
            scope.establecerTitulo = function(titulo){
                scope.titulo = titulo;
            };
            scope.establecerBotones = function(botones){
                scope.botones = botones;
            }
            function preguntar(titulo,texto,accionSi,accionNo){
                scope.establecerTitulo(titulo);
                scope.establecerContenido(texto);
                scope.establecerBotones([
                    {
                        texto:"si",
                        accion:function(){
                            scope.cerrar();
                            accionSi();
                        }
                    },
                    {
                        texto:"no",
                        accion:function(){
                            scope.cerrar();
                            accionNo();
                        }
                    }
                    ]);
                scope.abrir();
                scope.centrar();
            }
            function alerta(titulo,texto,accion){
                scope.establecerTitulo(titulo);
                scope.establecerContenido(texto);
                scope.establecerBotones([
                    {
                        texto:"si",
                        accion:function(){
                            scope.cerrar();
                            if(typeof accion !== undefined){
                                accion();
                            }
                        }
                    }
                    ]);
                scope.abrir();
                scope.centrar();
            }
            scope.btWindow = {
                abrir:scope.abrir,
                cerrar:scope.cerrar,
                centrar:scope.centrar,
                establecerContenido:scope.establecerContenido,
                establecerTitulo:scope.establecerTitulo,
                establecerUrl:scope.establecerUrl,
                establecerBotones:scope.establecerBotones,
                establecerUrl:scope.establecerUrl,
                preguntar:preguntar,
                alerta:alerta
            };
        }
    }
}])
.directive("btImageUploader",function(){
    return {
        restrict: "A",
        require:"ngModel",
        scope:{
            imagen:"=ngModel"
        },  
        templateUrl:"/Plantillas/Get/btImageUploader",
        link:function(scope,elem,attr,ngModel){
            var input = angular.element("<input type='file' accept='image/*'/>")[0];
            var name = attr.btName;
            var inputX = elem.find("#offsetX");
            var inputY = elem.find("#offsetY");
            var inputS = elem.find("#scale");
            var canvasElement = elem.find("canvas")[0];
            var original = null;
            scope.scale = 100;
            canvasElement.width = 100;
            canvasElement.height = 127;
            var canvas = canvasElement.getContext("2d");
            if(typeof name !== "undefined"){
                elem.find("input[type='hidden']").attr("name",name);
            }
            scope.offset = {
                x:0,y:0
            };
            function dibujar(){
                canvas.clearRect(0,0,canvasElement.width,canvasElement.height);
                if(typeof scope.imagen === "undefined"){
                    return;
                }
                var imagen = new Image();
                imagen.onload = function(){
                    var s = 1 + (1-scope.scale/100);
                    var x = scope.offset.x * s;
                    var y = scope.offset.y * s;
                    var w = imagen.width * s;
                    var h = imagen.height * s;
                    var ch = canvasElement.height;
                    var cw = canvasElement.width;
                    var ih = imagen.height;
                    var iw = imagen.width;
                    var mul = 1;
                    if(ch/cw > ih/iw){
                        mult =  ch/ih;
                    }else{
                        mult = cw/iw; 
                    }

                    canvas.drawImage(imagen,-x*iw/100,-y*ih/100,w*s,h*s,0,0,iw*mult,ih*mult);
                    /*setInterval(function(){
                        scope.$apply(function(){*/ngModel.$setViewValue(canvasElement.toDataURL());
                    /*});*/
                };
                imagen.src = original || scope.imagen;
            }
            ngModel.$render = function(){
                scope.original = scope.imagen;
                dibujar();
            };
            inputX.on("change",dibujar);
            inputY.on("change",dibujar);
            inputS.on("change",dibujar);
            scope.abrirDialogo = function(){
                angular.element(input).trigger("click");
            };
            angular.element(input).on("change",function(){
                if(input.files.length){
                    var file = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function(){
                        original = reader.result;
                        scope.imagen = reader.result;
                        dibujar();
                    };
                    reader.readAsDataURL(file);
                }
            });
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
            scope.fn = "Georgia";
            scope.tam = "3";
            scope.bold = false;
            scope.italic = false;
            scope.underline= false;
            var iframe  = el.find("iframe")[0];
            var doc = iframe.contentDocument;
            doc.designMode = "on";
            doc.onselectstart = function(evt){
                actualizarControles(evt.target);
            }
            var actualizarControles =  function(target){
                var font = "Georgia";
                var hasFont = false;
                var hasSize = false;
                var italic = false;
                var underline = false;
                var bold = false;
                var size = "3";
                while(target!==null && target.tagName !== "BODY"){
                    if(target.nodeName == "#text"){
                        target = target.parentElement;
                    }
                    switch(target.tagName){
                        case "FONT":
                        if(target.size && !hasSize){
                            size = target.size;
                            hasSize = true;
                        }
                        if(target.face && !hasFont){
                            font = target.face;
                            hasFont = true;
                        }
                        break;
                        case "B":
                        bold = true;
                        break;
                        case "U":
                        underline = true;
                        break;
                        case "I":
                        italic = true;
                        break;
                    }
                    target = target.parentElement;
                }
                setTimeout(function(){scope.$apply(function(){
                        scope.fn = font;
                        scope.tam = size;
                        scope.bold = bold;
                        scope.italic = italic;
                        scope.underline = underline;
                    });
                });
            };
            scope.comando = function($event,tipo,valor){
                doc.execCommand(tipo,true,valor);
                scope.actualizar();
                if(typeof $event !== "undefined"){
                    $event.preventDefault();
                    $event.stopPropagation();
                }
            };
            scope.actualizar = function(){
                scope.valor = doc.body.innerHTML;
            };
            doc.onkeyup = function(){
                var seleccion = doc.getSelection();
                actualizarControles(seleccion.anchorNode);
                ngModel.$setViewValue(doc.body.innerHTML);
            }
            scope.link = function(){
                var ventana = scope.ventana;
                ventana.establecerTitulo("vista_link");
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
directive("btAutoComplete",["$http","$document",function($http,$document){
    return{
        restrict: "A",
        require:"ngModel",
        scope:{
            btAutoComplete:"=",
            valores:"=ngModel"
        },
        templateUrl:"/plantillas/Get/btAutoComplete",
        link:function(scope,elem,attr,ngModel){
            var dataUrl = attr.btUrl;
            scope.clave = attr.btClave || "clave";
            scope.texto = attr.btTexto || "texto";
            scope.valores =  scope.valores || [];
            var setData = function(data){};
            scope.buscar = function(){
                scope.resultados = [];
                scope.abrir = function(){
                    if(scope.resultadosFiltrados.length!=0){
                        scope.abierto = true;
                    }
                }
                scope.resultadosFiltrados = [];
                if(scope.textoBusqueda.trim() != ""){
                    var data = {
                        texto:scope.textoBusqueda
                    };
                    setData(data,scope.texto);
                    $http({
                        url:dataUrl,
                        params:data
                    })
                    .then(function(respuesta){
                        scope.resultados = respuesta.data.data || respuesta.data;
                        scope.filtrar();
                        scope.abrir();
                    },
                    function(error){
                        var mensaje = error;
                        while(angular.isObject(mensaje)){
                            mensaje = mensaje.data || mensaje.error || mensaje.mensaje;
                        }
                        scope.ventana.establecerTitulo("Error");
                        scope.ventana.establecerContenido(mensaje);
                        scope.establecerBotones([
                                {
                                    texto:"aceptar",
                                    accion:function(){
                                        scope.ventana.cerrar();
                                    }
                                }
                            ]);
                        scope.ventana.abrir();
                        scope.ventana.cerrar();
                    })
                }
            };
            scope.cerrar = function(){
                scope.abierto = false;
            };
            function cerrarSiClickFuera($event){
                if($event.target !== elem && elem.has($event.target).length === 0){
                    scope.$apply(scope.cerrar);
                }
            };
            $document.on("click",cerrarSiClickFuera);
            scope.$on("destroy",function(){
                $documen.off("click",cerrarSiClickFuera);
            });
            scope.filtrar = function(){
                if(typeof scope.valores === "undefined"){
                    scope.valores = [];
                }
                scope.resultadosFiltrados = [];
                for(var i = 0; i < scope.resultados.length;i++){
                    var existe = false;
                    for(var j = 0; j < scope.valores.length; j++){
                        existe = existe || (scope.valores[j][scope.clave] == scope.resultados[i][scope.clave]);
                    }
                    if(!existe){
                        scope.resultadosFiltrados.push(scope.resultados[i]);
                    }
                }
            };
            scope.add = function(valor){
                var indice = scope.resultadosFiltrados.indexOf(valor);
                scope.resultadosFiltrados.splice(indice,1);
                scope.valores.push(valor);
            };
            scope.eliminar = function(indice){
                var elemento = scope.valores.splice(indice,1)[0];
                if(elemento[scope.clave]){
                    if(typeof scope.resultadosFiltrados === "undefined"){
                        scope.resultadosFiltrados = [];
                    }
                    scope.resultadosFiltrados.push(elemento);
                }
            };
            scope.nuevo = function(){
                var elemento = {};
                elemento[scope.clave] = 0;
                elemento[scope.texto] = scope.texto;
                elemento["puntuacion"]  = 1;
                scope.valores.push(elemento);
            }
            scope.btAutoComplete = {
                url:function(url){
                    if(typeof url !== "undefined"){
                        return dataUrl;
                    }else{
                        dataUrl = url;
                    }
                },
                setClave:function(c){
                    clave = c;
                },
                setTexto:function(t){
                    texto = t;
                }
            };
        }
        
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
.directive("btFileInput",function(){
    return{
        restrict:"A",
        require:"ngModel",
        scope:{
            btFileInput:"=",
            files:"=ngModel"
        },
        templateUrl:"/plantillas/Get/btFileInput",
        link:function(scope,elem,attr,ngModel){
            scope.estado = "";
            elem.on("dragover",function(evt){
                var transfer = evt.originalEvent.dataTransfer;
                var tipo = transfer.items[0].kind;
                if(tipo=="file"){
                    evt.preventDefault();
                    evt.stopPropagation();
                    scope.estado = "enmarcado";
                }
            });
            elem.on("dragleave",function(evt){
                scope.estado = "";
            })
            elem.on("drop",function(evt){
                ngModel.$setViewValue(evt.originalEvent.dataTransfer.files);
                evt.preventDefault();
                evt.stopPropagation();
            });
            var elemHtml = "<input type='file'";
            if(attr.btAccept){
                elemHtml += " accept='"+attr.btAccept+"'";
            }
            elemHtml+="/>";
            var input = angular.element(elemHtml)[0];
            scope.abrirDialogo = function(){
                angular.element(input).trigger("click");
            };
            input.onchange = function(){
                ngModel.$setViewValue(input.files);
            };
            ngModel.$render = function(){

            };
        }
    }
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
            scope.cancelar = function(){
                scope.indiceEdicion = -1;
                scope.insertando = false;
            };
            scope.editar = function(evento,indice){
                scope.vista = angular.copy(scope.experiencias[indice]);
                scope.indiceEdicion = indice;
                scope.insertando = false;
            };
            scope.borrar = function(evento,indice){
                scope.ventana.preguntar("confirmar_eliminar_titulo","confirmar_eliminar",
                    function(){
                        $http({
                            url:"/api/Experiencias/Delete",
                            method: "POST",
                            data: $.param({elem:scope.experiencias[indice]}),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                            .then(function(respuesta){
                                scope.experiencias.splice(indice,1);
                            },
                            function(error){
                                vetana.alerta(error,error.data||error.mensaje,function(){});
                                });
                    },
                    function(){

                    });
            }; 
           	function cargarConocimientos(experiencia){
           		if(typeof experiencia !== "undefined" && experiencia.id_experiencia){
           			$http({
           				url:"/api/Experiencias/Conocimientos/" + experiencia.id_experiencia
           			}).
           			then(function(respuesta){
           				experiencia.conocimientos = respuesta.data;
           			},function(error){});
           		}
           	}
			scope.insertar = function(){
				scope.vista = true;
                scope.vista = {};
				scope.indiceEdicion = -1;
				scope.insertando = true;
			};
            scope.aplicarEdicion = function(evento,indice){
                //TODO: Validar en cliente
                $http({
                    url:"/api/Experiencias/Update",
                    method:"POST",
                    data:$.param({nuevo:scope.vista, viejo:scope.experiencias[indice]}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(respuesta){
                    scope.experiencias[indice] = respuesta.data[0];
                    cargarConocimientos(scope.experiencias[indice]);
                    scope.indiceEdicion = -1;
                    scope.insertando = false;
                },
                function(error){
                    scope.vetana.alerta("error",error.mensaje ||error.data);
                });
            };
            scope.aplicarInsertar = function(evento){
                //TODO: Validar en cliente
                $http({
                    url:"/api/Experiencias/Insert",
                    method:"POST",
                    data:$.param(scope.vista),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(respuesta){
                    scope.experiencias.unshift(respuesta.data);
                    cargarConocimientos(scope.experiencias[0]);
                    scope.indiceEdicion = -1;
                    scope.insertando = false;
                },
                function(error){
                    scope.ventana.alerta("error",error.mensaje ||error.data,function(){});
                });
            };
			ngModel.$render = function(){
				if(typeof scope.alumno === "undefined"){
					return;
				}
				$http({
					url: "/api/Experiencias/Get/" + scope.alumno.id_alumno
				})
				.then(
					function(respuesta){
						scope.experiencias = respuesta.data.data;
						for(var indice in scope.experiencias){
							cargarConocimientos(scope.experiencias[indice]);
						}
				},
					function(error){
						scope.ventana.alerta("error",error.data?error.data:error,function(){});
					});
			};
		}
	};
}])
.directive("btFormacionAcademica",["$http",function($http){
	return{
		scope:{
			alumno:"=ngModel"
			},
            require:"ngModel",
			templateUrl:"/Alumno/FormacionAcademica",
			link:function(scope,elemento,atributos,ngModel){
			function error(respuesta){
                scope.ventana.alert("error",respuesta.data);
            }
			scope.insertar = function(){
                if(!scope.insertando){
                    scope.vista = {};
				    scope.indiceEdicion = -1;
				    scope.insertando = true;
                }
			};
            scope.eliminar = function(indice){
                scope.ventana.preguntar("confirmar_eliminar_titulo",
                    "confirmar_eliminar",function(){
                        scope.ventana.cerrar();
                        $http({
                        url:"/api/FormacionAcademica/Delete",
                        method:"POST",
                        data:$.param({
                            elem:scope.formaciones[indice]
                        }),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .then(function(respuesta){
                        scope.formaciones.splice(indice,1);
                        scope.cancelar();
                    },error);
                    },function(){
                        scope.ventana.cerrar();
                    });
            };
            scope.editar = function(indice){
                scope.indiceEdicion = indice;
                scope.insertando = false;
                scope.vista = angular.copy(scope.formaciones[indice]);
            };
            scope.cancelar = function(){
                scope.vista = {};
                scope.indiceEdicion = -1;
                scope.insertando = false;
            };
            scope.OnCursandoClick = function(){
                var contr = elemento.find("#fecha_fin").controller("ngModel");
                contr.$validators.required = function(fecha){
                    return scope.vista.cursando || fecha!==null && fecha.trim() != ""
                };
                contr.$validate();
            };
            function cargarConocimientos(formacion){
            	if(typeof formacion !== "undefined"&& formacion.id_formacion_academica){
            		$http({
            			url:"/api/FormacionAcademica/Conocimientos/" + formacion.id_formacion_academica
            		})
            		.then(function(respuesta){
            			formacion.conocimientos = respuesta.data;
            		},function(error){
            			
            		});
            	}
            }
            scope.aplicarEdicion = function(){
                scope.formInsertar = elemento.find("[ng-form='ins']").controller("form");
                scope.formInsertar.$setSubmitted(true);
                if(scope.formInsertar.$valid){
                    $http({
                        url:"/api/FormacionAcademica/Update",
                        method:"POST",
                        data:$.param({
                            nuevo:scope.vista,
                            viejo:scope.formaciones[scope.indiceEdicion]
                        }),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .then(function(respuesta){
                        scope.formaciones[scope.indiceEdicion] = (respuesta.data.data ||  respuesta.data)[0];
                        cargarConocimientos(scope.formaciones[scope.indiceEdicion]);
                        scope.cancelar();
                    },error);
                }
            };
            scope.aplicarInsertar = function(){
                scope.formInsertar = elemento.find("[ng-form='ins']").controller("form");
                scope.formInsertar.$setSubmitted(true);
                if(scope.formInsertar.$valid){
                    $http({
                        url:"/api/FormacionAcademica/Insert",
                        method:"POST",
                        data:$.param(scope.vista),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .then(function(respuesta){
                        scope.formaciones.unshift((respuesta.data.data ||  respuesta.data)[0]);
                        cargarConocimientos(scope.formaciones[0]);
                        scope.cancelar();
                    },error);
                }
            };
			ngModel.$render = function(){
                if(typeof scope.alumno !== "undefined"){
					$http({
						url:"/api/FormacionAcademica/Get/" + scope.alumno.id_alumno
					})
					.then(function(respuesta){
						scope.formaciones = respuesta.data.data;
						for(var i in scope.formaciones){
							cargarConocimientos(scope.formaciones[i]);
						}
					},function(error){
						
					});
                }
			};
			}
		};
}])
.directive("btFormacionComplementaria",["$http",function($http){
	return{
		scope:{
			alumno:"=ngModel"
			},
            require:"ngModel",
			templateUrl:"/Alumno/FormacionComplementaria",
			link:function(scope,elemento,atributos,ngModel){
			scope.cancelar =  function(){
				scope.indiceEdicion = -1;
				scope.insertando = false;
                scope.vista = {};
			};
			scope.editar = function(indice){
				scope.indiceEdicion = indice;
				scope.formaciones[indice].horas = parseInt(scope.formaciones[indice].horas);
                scope.vista = angular.copy(scope.formaciones[indice]);
				scope.insertando = false;
			};
            scope.eliminar = function(indice){
                scope.ventana.preguntar("confirmar_eliminar_titulo","confirmar_eliminar",
                    function(){
                        scope.ventana.cerrar();
                        $http({
                            url:"/api/FormacionComplementaria/Delete",
                            method: "POST",
                            data: $.param({elem:scope.formaciones[indice]}),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        })
                        .then(
        	                function(respuesta){
        	                    scope.formaciones.splice(indice,1);
        	                },
        	                function(error){
                                    scope.ventana.alerta(error.data,function(){
                                        scope.ventana.cerrar();
                                    });
                        	}
                        );
                    },function(){}
                );
            };
			scope.insertar = function(){
                scope.vista = true;
                scope.vista = {};
				scope.indiceEdicion = -1;
				scope.insertando = true;
			};
            scope.nombresTiposTitulacion = {};
            scope.nomrbesOfertasFormativas = {};
            for(var i in scope.tipos_titulacion){
                scope.nombresTiposTitulacion[scope.tipos_titulacion[i.id_tipo_titulacion]] = scope.tipos_titulacion[i].nombre;
            }
            for(var i in scope.ofertas_formativas){
                scope.nomrbesOfertasFormativas[scope.ofertas_formativas[i.id_oferta_formativa]] = scope.ofertas_formativas[i].nombre;
            }

			scope.aplicarEdicion = function(){
				$http({
                    url:"/api/FormacionComplementaria/Update",
                    method: "POST",
                    data: $.param({
                        viejo:scope.formaciones[scope.indiceEdicion],
                        nuevo:scope.vista
                    }),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                .then(
                    function(respuesta){
                        scope.formaciones[scope.indiceEdicion]=respuesta.data[0];
                        cargarConocimientos(scope.formaciones[scope.indiceEdicion]);                       
						scope.indiceEdicion = -1;
						scope.insertando = false;
                    },
                    function(error){

                    }
                );
			};
            scope.aplicarInsertar = function(){
                $http({
                    url:"/api/FormacionComplementaria/Insert",
                    method: "POST",
                    data: $.param(scope.vista),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                .then(
                    function(respuesta){
                        scope.formaciones.unshift(respuesta.data[0]);
                        cargarConocimientos(scope.formaciones[0]);
                    },
                    function(error){

                    }
                );
                scope.indiceEdicion = -1;
                scope.insertando = false;
            };
            function cargarConocimientos(formacion){
                $http({
                        url:"/api/FormacionComplementaria/Conocimientos/" + formacion.id_formacion_complementaria
                }).then(function(respuesta){
                        formacion.conocimientos = respuesta.data;
                },function(error){});
            }
				ngModel.$render = function(){
                    if(typeof scope.alumno !== "undefined"){
    					$http({
    						url:"/api/FormacionComplementaria/Get/" + scope.alumno.id_alumno
    					})
    					.then(function(respuesta){
    						scope.formaciones = respuesta.data.data;
                            for(var i in scope.formaciones){
                                cargarConocimientos(scope.formaciones[i]);
                            }
    					},function(error){
    						
    					});
                    }
				};
			}
		}
}])
.controller("btMostrarFormacionComplementaria",["$scope","$http", function($scope,$http){
    $scope.editar = function(){
        $scope.$emit("editar_formacion", {
            indice:$scope.$index
        });
    };
    $scope.borrar = function(){
        $scope.$emit("borrar_formacion",{
            indice:$scope.$index
        });
    }
    $http({
        url:"/api/TipoTitulacion/GetById/"+$scope.formacion.id_tipo_titulacion
    })
    .then(function(respuesta){
        $scope.nombre_tipo_titulacion = respuesta.data.data[0].nombre;
    },
    function(error){
        alert(error);
    });
     $http({
        url:"/api/OfertaFormativa/GetById/"+$scope.formacion.id_oferta_formativa
    })
    .then(function(respuesta){
        $scope.nombre_oferta_formativa = respuesta.data.data[0].nombre;
    },
    function(error){
        alert(error);
    })
}])
.controller("btEditarFormacionComplementaria",["$scope","$http", function($scope,$http){

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
					url: "/api/FormacionComplementaria/Update",
					method: "POST",
					data: $.param({
						viejo:$scope.formacion,
						vista:$scope.vista
						}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				};
				if(typeof $scope.insertando !== "undefined" && $scope.insertando){
					config.url = "/api/FormacionComplementaria/Insert";
					config.data = $.param($scope.vista);
				}
				$http(config)
				.then(
					function(respuesta){
						var args = {formacion:respuesta.data[0]};
						if(typeof $scope.vista !== "undefined" && $scope.vista){
							args.vista = true;
						}
						$scope.$emit("aplicar_edicion_formacion",args);
					},
					function(error){
						
					}
				);
			};

            $scope.cargarOfertas = function(){
                $http({url:"/api/OfertaFormativa/GetByTipo/" +$scope.vista.id_tipo_titulacion})
                .then(
                    function(respuesta){
                        $scope.ofertas = respuesta.data.data;
                    },
                    function(error){

                    }
                  );
            };
            if(typeof $scope.formacion !== "undefined"){
                $scope.vista = angular.copy($scope.formacion);
                $scope.cargarOfertas();
            }	
}])
.controller("btMostrarFormacionAcademica",["$scope","$http", function($scope,$http){
    $scope.editar = function(){
        $scope.$emit("editar_formacion", {
            indice:$scope.$index
        });
    };
    $scope.borrar = function(){
        $scope.$emit("borrar_formacion",{
            indice:$scope.$index
        });
    }
    $http({
        url:"/api/TipoTitulacion/GetById/"+$scope.formacion.id_tipo_titulacion
    })
    .then(function(respuesta){
        $scope.nombre_tipo_titulacion = respuesta.data.data[0].nombre;
    },
    function(error){
        alert(error);
    });
     $http({
        url:"/api/OfertaFormativa/GetById/"+$scope.formacion.id_oferta_formativa
    })
    .then(function(respuesta){
        $scope.nombre_oferta_formativa = respuesta.data.data[0].nombre;
    },
    function(error){
        alert(error);
    })
}])
.controller("btEditarFormacionAcademica",["$scope","$http", function($scope,$http){

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
						viejo:$scope.formacion,
						vista:$scope.vista
						}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				};
				if(typeof $scope.vista !== "undefined" && $scope.vista){
					config.url = "/api/FormacionAcademica/Insert";
					config.data = $.param($scope.vista);
				}
				$http(config)
				.then(
					function(respuesta){
						var args = {formacion:respuesta.data[0]};
						if(typeof $scope.vista !== "undefined" && $scope.vista){
							args.vista = true;
						}
						$scope.$emit("aplicar_edicion_formacion",args);
					},
					function(error){
						
					}
				);
			};

            $scope.cargarOfertas = function(){
                $http({url:"/api/OfertaFormativa/GetByTipo/" +$scope.vista.id_tipo_titulacion})
                .then(
                    function(respuesta){
                        $scope.ofertas = respuesta.data.data;
                    },
                    function(error){

                    }
                  );
            };
            if(typeof $scope.formacion !== "undefined"){
                $scope.vista = angular.copy($scope.formacion);
                $scope.cargarOfertas();
            }	
}])
.directive("btPerfilAlumnosDatosPersonales",["$http",function($http){
    return {
            restrict:"A",
            require:"ngModel",
            scope:{
                btPerfilAlumnosPersonales:"=",
                alumno:"=ngModel"
            },
            templateUrl:"/Alumno/DatosPersonales",
            link:function(scope,elem,attr,ngModel){
            	
	        scope.eliminarCurriculum = function(){
                scope.ventana.preguntar("confirmar_eliminar_titulo","confirmar_eliminar",function(){
                    scope.ventana.cerrar();
                    $http({
                        url:"/api/Alumnos/EliminarCurriculum"
                    }).then(function(respuesta){
                        scope.ventana.alerta("eliminado","curriculum_eliminado",function(){
                           scope.ventana.cerrar();
                            scope.tieneCurriculum = false;
                        });
                    },function(error){
                        scope.ventana("error",error.data||error.message||error,function(){
                            scope.venana.cerrar();
                        })
                    });
                });
            };
			scope.eliminarcuenta = function(){
				scope.ventana.establecerUrl("/Alumno/confirmarEliminarCuenta");
				scope.ventana.establecerTitulo("eliminar_cuenta_titulo");
				scope.ventana.establecerBotones([
					{
						texto:"aceptar",
						accion:function(){
							var clave = angular.element("#confirmar_clave").val();
							$http({
								url:"/api/Alumnos/Baja",
								method:"POST",
								data:$.param({
									clave:clave
								}),
								headers: {'Content-Type': 'application/x-www-form-urlencoded'}
							})
							.then(
								function(respuesta){
									window.location = "/Login";
								},
								function(error){
									alert(error.data || error.message || error);
									scope.ventana.cerrar();
									angular.element("#confirmar_clave").val("");
								}
							);
						}
					},
					{
						texto:"cancelar",
						accion:function(){
							scope.ventana.cerrar();
							angular.element("#confirmar_clave").val("");
						}
					}
				]);
				scope.ventana.centrar();
				scope.ventana.abrir();
			};
                function mostrarMensajeError(error){
                    var mensaje = error;
                    while(angular.isObjet(error)){
                        mensaje = mensaje.data || mensaje.error || mensaje.mensaje;
                    }
                    var ventana = scope.ventana;
                    ventana.establecerTitulo("Error");
                    ventana.establecerContenido(mensaje);
                    ventana.establecerBotones([
                            {
                                texto:"aceptar",
                                accion:function(){
                                    ventana.cerrar();
                                }
                            }
                        ]);
                    ventana.abrir();
                    ventana.centrar();
                }
                ngModel.$render = function(){
                    if(typeof scope.alumno !== "undefined"  && scope.alumno.id_localidad){
                        $http({
                            url:"/api/Alumnos/TieneCurriculum"
                        }).then(function(respuesta){
                               scope.tieneCurriculum = respuesta.data;
                            });
                        $http({
                            url:"/api/Provincias/GetByLocalidad/"+scope.alumno.id_localidad
                        }).then(
                            function(respuesta){
                                scope.id_provincia = respuesta.data.provincia.id_provincia;
                                scope.nombre_provincia = respuesta.data.provincia.nombre;
                                scope.nombre_localidad = respuesta.data.localidad.nombre;
                                scope.cargarLocalidades();
                            },
                            mostrarMensajeError
                        );
                    }
                    if(typeof scope.alumno !== "undefined"){
                        $http({
                            url:"/api/Alumnos/CargarImagen"
                        }).then(
                            function(respuesta){
                                scope.imagen = respuesta.data.imagen;
                            },
                            mostrarMensajeError
                        );
                    }
                };
                scope.cargarLocalidades = function(){
                    if(scope.id_provincia){
                        $http({
                            url:"/api/Localidades/GetDeProvincia/"+scope.id_provincia
                        }).then(
                            function(respuesta){
                                scope.localidades = respuesta.data;
                            },
                            function(error){
                                mostrarMensajeError(error);
                            }
                        );
                    }
                };
                scope.editar = function(){
                    scope.vista = angular.copy(scope.alumno);
                    scope.imagen_copia = angular.copy(scope.imagen);
                    scope.editando = true;
                };
                scope.cancelar = function(){
                    scope.vista = {};
                    scope.editando = false;
                    scope.editandoclave = false;
                };
                var controles = {
                    nombre:elem.find("#nombre").controller("ngModel"),
                    apellido1:elem.find("#apellido1").controller("ngModel"),
                    apellido2:elem.find("#apellido2").controller("ngModel"),
                    dni:elem.find("#dni").controller("ngModel"),
                    tlf:elem.find("#tlf").controller("ngModel"),
                    nacionalidad:elem.find("#nacionalidad").controller("ngModel"),
                    calle:elem.find("#calle").controller("ngModel")
                };
                controles.dni.$parsers.push(function(dni){
                    return dni.replace("-","").replace(" ","");
                });
                controles.dni.$validators.dni  = function(dni){
                    if(typeof dni === "undefined" || !dni){
                        return false;
                    }
                    dni = dni.replace("-","").replace(" ","");
                    if(dni.length!=9){
                        return false;
                    }
                    var letras = ["T","R","W","A","G","M","Y","F","P","D","X","B",
                            "N","J","Z","S","Q","V","H","L","C","K","E"];
                    var n = dni.substr(0,8).toUpperCase();
                    n = n.replace("X","0").replace("Y","1").replace("Z","2");
                    var resto = n%23;
                    var letra = dni[8];
                    return letra == letras[resto];
                };
                scope.guardar = function(){
                        $http({url: "/api/Alumnos/GuardarPerfil", 
                                method: "POST", 
                                data: $.param(scope.vista),
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(
                                function(respuesta){
                                    scope.cancelar();
                                    scope.alumno = respuesta.data;
                        },
                                function(error){
                                    mostrarMensajeError(error);
                                }
                        );
                        $http({url: "/api/Alumnos/GuardarImagen", 
                                method: "POST", 
                                data: $.param({imagen:scope.imagen_copia}),
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(
                            function(respuesta){
                                scope.imagen = respuesta.data.imagen;
                            },
                            function(error){
                                mostrarMensajeError(error);
                            }
                        );
                    };
                   	scope.mostrarcambiarclave = function(){
						scope.editandoclave =2;
					};
					
					scope.subirCV = function(){
						var input = angular.element("<input type='file' accept='.pdf|.doc|.docx'/>")[0];
						input.onchange = function(evento){
							var formData = new FormData();
							formData.append('cv', input.files[0]);
							$http.post('/api/Alumnos/SubirCV', formData, {
								transformRequest: angular.identity,
								headers: {
									'Content-Type': undefined
								}
							}).then(function(respuesta){
                              scope.tieneCurriculum = true;
                            },function(error){
                                scope.ventana.alerta("error",error.data||error.message||error,function(){
                                   scope.ventana.cerrar();
                                });
                            });
						};
						angular.element(input).trigger("click");
					};

            }      
    };
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
}]).controller("alumnoPerfilIdiomasController",["$http","$scope",function($http,$scope){
        $scope.$watch("alumno.id_alumno",function(){
            if( typeof $scope.alumno !== "undefined" && typeof $scope.alumno.id_alumno !== "undefined"){
                $http({
                    url:"/api/Idioma/Get/"+$scope.alumno.id_alumno
                })       
                .then(function(respuesta){
                    if(respuesta.data.data){
                        $scope.idiomas = respuesta.data.data;
                    }else{
                        $scope.idiomas = respuesta.data;
                    }
                },function(error){
                    alert(error);
                });
            }
        });
        $scope.aplicarInsertar = function(){
            $http({
                url:"/api/Idioma/Insert",
                method:"POST",
                data: $.param($scope.vista),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function(respuesta){
                $scope.idiomas.unshift(respuesta.data[0]);
                $scope.cancelar();
            },function(error){
                alert(error);
            })
        };
        $scope.eliminar = function(indice){
            $http({
                url:"/api/Idioma/Delete",
                method:"POST",
                data: $.param({elem:$scope.idiomas[indice]}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function(respuesta){
                $scope.idiomas.splice(indice,1);
            },function(error){
                alert(error);
            })
        };
        $scope.aplicarEdicion = function(indice){
            $http({
                url:"/api/Idioma/Update",
                method:"POST",
                data: $.param({nuevo:$scope.vista,viejo:$scope.idiomas[indice]}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function(respuesta){
                $scope.idiomas[indice] = respuesta.data[0];
                $scope.cancelar();
            },function(error){
                alert(error);
            })
        };
        $scope.insertar = function(){
            $scope.indiceEdicion = -1;
            $scope.insertando = true;
            $scope.vista = {};
        };
        $scope.editar = function(indice){
            $scope.insertando = false;
            $scope.indiceEdicion = indice;
            $scope.vista = angular.copy($scope.idiomas[indice]);
        };
        $scope.cancelar = function(){
            $scope.insertando = false;
            $scope.indiceEdicion = -1;
        };
}])
.directive("btBuscadorAlumnos",["$http",function($http){
	return {
		restrict:"A",
		require:"ngModel",
		scope:{
			oferta:"=ngModel"
		},
		templateUrl:"/plantillas/Get/BTBuscadorAlumno?coleccion=oferta_formativa",
		link:function(scope,el,at,ngModel){
			scope.filtros = JSON.parse(sessionStorage.getItem("filtros_alumnos") || "{}");
			scope.seleccionados = [];
			scope.vista = [];
			scope.buscar = function(){
				sessionStorage.setItem("filtros_alumnos",JSON.stringify(scope.filtros));
				$http({
					url:"/api/Alumnos/Buscar",
					method:"POST",
					data:$.param({filtros:scope.filtros}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
				.then(function(respuesta){
					scope.alumnos = respuesta.data;
					filtrar();
				},function(error){
					
				});
				
			};
			function filtrar(){
				scope.vista = [];
				for(var indiceAlumno in scope.alumnos){
					var existe = false;
					for(var indiceS in scope.seleccionados){
						existe = existe || scope.seleccionados[indiceS].id_alumno == scope.alumnos[indiceAlumno].id_alumno;
					}
					if(!existe){
						scope.vista.push(scope.alumnos[indiceAlumno]);
					}
					
				}
			}
			scope.seleccionar = function(indice){
				var alumno = scope.vista.splice(indice,1)[0];
				scope.seleccionados.push(alumno);
			};
			scope.deseleccionar = function(indice){
				var alumno = scope.seleccionados.splice(indice,1)[0];
				scope.vista.push(alumno);
			};
			scope.guardar = function(){
				var ids_alumnos = [];
				for(var i in scope.seleccionados){
					ids_alumnos.push(scope.seleccionados[i].id_alumno);
				}
				$http({
					url:"/api/Ofertas/ActualizarCandidatos",
					method:"POST",
					data: $.param({
						id_oferta:scope.oferta.id_oferta,
						alumnos:ids_alumnos
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
				.then(function(respuesta){
					alert("Se han guardado los cambios");
				},function(error){
					
				});
			};
			ngModel.$render = function(){
				if(typeof scope.oferta !== "undefined" && scope.oferta && scope.oferta.id_oferta){
					$http({
						url:"/api/Ofertas/Candidatos/" + scope.oferta.id_oferta
					})
					.then(function(respuesta){
						scope.seleccionados = respuesta.data;
					},function(error){});
				}
			};
		}
	};
}])
.directive("btNotasAlumnos",["$http",function($http){
    return {
       restrict:"A",
        require:"ngModel",
        scope:{
            alumno:"=ngModel",

        },
        templateUrl:"/plantillas/Get/btNotasAlumnos",
        link:function(scope,elemento,atributo,ngModel){
            scope.insertando = false;
            scope.notas = [];
            ngModel.$render = function(){
                if(typeof scope.alumno !== "undefined" && scope.alumno.id_alumno){
                    $http({
                        url:"/api/NotasAlumnos/Get/" + scope.alumno.id_alumno
                    })
                    .then(function(respuesta){
                        scope.notas = respuesta.data;
                    },function(error){
                       scope.ventana.alerta("error",error.data ||  error.message,function(){scope.ventana.close();});
                    });
                }
            };
            scope.insertar = function(){
                scope.insertando = true;
            };
            
            scope.cancelar = function(){
            	scope.insertando = false;
            };
            
            scope.guardar = function(){
            	$http({
            		url: "/api/NotasAlumnos/Insert",
            		method: "POST",
            		data:$.param({
            			id_alumno: scope.alumno.id_alumno,
            			nota: scope.nueva_nota
            		}),
            		headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            	})
            	.then(
            		function(respuesta){
            			ngModel.$render();
            			scope.cancelar();
            		},
            		function(error){
            			scope.ventana.alerta("error",error.data ||  error.message,function(){scope.ventana.close();});

            		}
            	);
            };
        }
    };
}])
.directive("btBtnCarga",function(){
    return{
        restrict:"A",
        scope:{
            cargando:"=btCargando"
        },
        template:function(e,a){
            var nCuadros = a.btNCuadros || 8;
            var cuadros = "<div class='contenedor-texto'>"+e.html()+"</div><div class='contenedor-cuadros'>";
            for(var i = 0; i < nCuadros ; i++){
                cuadros += "<div style='animation-delay:"+(0.2+(0.2*i))+"s'>&nbsp;</div>";
            }
            return cuadros + "</div>";
        },
        link:function(scope,elem,attr){
            
        }
    }
});