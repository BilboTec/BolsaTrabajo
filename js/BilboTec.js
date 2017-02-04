angular.module("BilboTec.ui",["ngAnimate"]);
angular.module("BilboTec",["BilboTec.ui", "ngRoute"])
.filter("btDate",function(){
	return function(date){
		return date.split(" ")[0];
	};
})
.filter("diferencia_fecha",function(){
    return function(fecha){
    	if(typeof fecha === "undefined"){
    		return;
    	}
    	var ahora = new Date();
    	var desde = new Date(fecha);
        var tiempo = ahora.getTime() - desde.getTime();
        var tiempos = {
        	"segundos":1000,
        	"minutos":60,
        	"horas":60,
        	"días":24
        };
        for(var ext in tiempos){
        	if(tiempo>tiempos[ext]){
        		tiempo= tiempo/tiempos[ext];
        	}else{
        		return tiempo.toFixed(0) + " "+ext;
        	}
        }
        return tiempo.toFixed(0) + " dias";
    }
})
.config(function($routeProvider){
	var diccionarioDirecciones = {
		"/Profesor/Ofertas":{
			"/":{templateUrl:"/Profesor/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Profesor/DetalleOferta", controller:"detalleOferta"},
			"/Editar/:id_oferta":{templateUrl:"/Profesor/EditarOferta", controller:"detalleOferta"}
		},
		"/Profesor/":{
			"/":{templateUrl:"/Profesor/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Profesor/DetalleOferta", controller:"detalleOferta"},
			"/Editar/:id_oferta":{templateUrl:"/Profesor/EditarOferta", controller:"detalleOferta"}
		},
		"/Profesor":{
			"/":{templateUrl:"/Profesor/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Profesor/DetalleOferta", controller:"detalleOferta"},
			"/Editar/:id_oferta":{templateUrl:"/Profesor/EditarOferta", controller:"detalleOferta"}
		},
		"/Profesor/Perfil":{
			"/":{templateUrl:"/Profesor/DatosPerfil", controller:"controladorDatosProfesor"},
			"/Clave":{templateUrl:"/Profesor/CambiarClave", controller:"controladorClaveProfesor"},
			"/Editar":{templateUrl:"/Profesor/editarPerfil", controller:"controladorDatosProfesor"}
		},
		"/Profesor/Alumnos":{
			"/":{templateUrl:"/Profesor/BuscarAlumno", controller:"controladorProfesorBuscarAlumno"},
			"/InvitarAlumnos":{templateUrl:"/Profesor/InvitarAlumnos", controller:"controladorInvitarAlumnos"},
			"/:id_alumno":{templateUrl:"/Profesor/DetalleAlumno", controller:"controladorDetalleAlumno"}
		},
		"/Profesor/Empresas":{
			"/":{templateUrl:"/Profesor/BuscarEmpresa", controller:"controladorProfesorBuscarEmpresa"},
			"/AnadirEmpresa":{templateUrl:"/Profesor/DetalleEmpresa", controller:"controladorAnadirEmpresa"},
			"/CambiarClave/:id_empresa":{templateUrl: "/Profesor/CambiarClave", controller:"controladorCambiarClaveEmpresa"},
			"/:id_empresa":{templateUrl:"/Profesor/DetalleEmpresa", controller:"controladorDetalleEmpresa"}
		},

		"/Alumno/Ofertas":{
			"/":{templateUrl:"/Alumno/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Alumno/DetalleOferta", controller:"detalleOfertaAlumno"}
		},
		"/Alumno/":{
			"/":{templateUrl:"/Alumno/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Alumno/DetalleOferta", controller:"detalleOfertaAlumno"}
		},
		"/Alumno":{
			"/":{templateUrl:"/Alumno/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Alumno/DetalleOferta", controller:"detalleOfertaAlumno"}
		},
		"/Alumno/Perfil":{
			"/":{templateUrl:"/Alumno/DatosPerfil", controller:"controladorDatosAlumno"},
			"/Clave":{templateUrl:"/Alumno/CambiarClave", controller:"controladorClaveAlumno"},
			"/Editar":{templateUrl:"/Alumno/editarPerfil", controller:"controladorDatosAlumno"}
		},
		"/Alumno/Candidaturas":{
			"/":{templateUrl:"/Alumno/listaCandidaturas"},
			"/:id_oferta":{templateUrl:"/Alumno/DetalleOferta", controller:"detalleOfertaAlumno"}
		},

		"/Empresa/Ofertas":{
			"/":{templateUrl:"/Empresa/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Empresa/DetalleOferta", controller:"detalleOfertaEmpresa"}
		},
		"/Empresa/":{
			"/":{templateUrl:"/Empresa/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Empresa/DetalleOferta", controller:"detalleOfertaEmpresa"}
		},
		"/Empresa":{
			"/":{templateUrl:"/Empresa/BuscarOferta", controller:"busquedaOfertas"},
			"/:id_oferta":{templateUrl:"/Empresa/DetalleOferta", controller:"detalleOfertaEmpresa"}
		},
		"/Empresa/Perfil":{
			"/":{templateUrl:"/Empresa/DatosPerfil", controller:"controladorDatosEmpresa"},
			"/Clave":{templateUrl:"/Empresa/CambiarClave", controller:"controladorClaveEmpresa"},
			"/Editar":{templateUrl:"/Empresa/editarPerfil", controller:"controladorDatosEmpresa"}
		}
		
	};
	var pathname = location.pathname;
	direcciones = diccionarioDirecciones[pathname];
	for(var ruta in direcciones){
		$routeProvider.when(ruta,direcciones[ruta])
	}
	$routeProvider.otherwise({redirectTo:"/"});
})
.controller("altaEmpresaController",["$http","$scope",function($http,$scope){
	$scope.onPaisCambiado = function(){
		$scope.hayProvincias = $scope.empresa.id_pais===$scope.id_es;
	};
	$scope.onProvinciaCambiada =function(){
		$http({
			url:"/api/Localidades/GetDeProvincia/"+$scope.empresa.id_provincia
		}).then(function(respuesta){
			$scope.localidades = respuesta.data;
			$scope.hayLocalidades =true;
		},function(error){
			alert(error.data?error.data:error);
		});
	};
	$scope.onSubmit = function($event){
		var empresa = $scope.empresa;
		if(!$scope.formAltaEmpresa.$valid || empresa.clave !== empresa.clave2){
			$scope.formAltaEmpresa.$setSubmitted(true);
			$event.preventDefault();
		}
	};
}])
.controller("formularioLoginController",["$scope","$http",function($scope,$http){
	$scope.validarLogin = function($event){
		$scope.formLogin.$setSubmitted(true);
		if($scope.formLogin.$invalid){
			$event.preventDefault();
		}
	};
}])
.controller("idiomaController", ["$scope","$http",function($scope,$http){
	$scope.cambiarIdioma = function(idioma){
	$http.get("/Idioma/cambiar/" + idioma).then(function(respuesta){
		window.location.reload();
	}, function(error){
		alert(error.data?error.data:error);
	});
	};
}])
.controller("administradorController", function($scope){
	$scope.filas= [];
	$scope.resultadosXpagina = [
	{
		texto: "5",
		valor: 5
	},
	{
		texto: "10",
		valor: 10
	},
	{
		texto: "20",
		valor: 20
	},
	{
		texto: "50",
		valor: 50
	},
	{
		texto: "100",
		valor: 100
	}
	];
	
	$scope.configuraciones = {
		conocimientos: {
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				}
			},
			leer: {
				url: "/api/Conocimientos/Get"
			},
			insertar: {
				url: "/api/Conocimientos/Insert"
			},
			actualizar: {
				url: "/api/Conocimientos/Update"
			},
			eliminar: {
				url: "/api/Conocimientos/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		
		departamentos:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre:{
	                    spanish:"Nombre",
	                    basque:"Izena"
                	}
				}
			},
			leer: {
				url: "/api/Departamentos/Get"
			},
			insertar: {
				url: "/api/Departamentos/Insert"
			},
			actualizar: {
				url: "/api/Departamentos/Update"
			},
			eliminar: {
				url: "/api/Departamentos/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		
		tipo_titulacion:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				}
			},
			leer: {
				url: "/api/TipoTitulacion/Get"
			},
			insertar: {
				url: "/api/TipoTitulacion/Insert"
			},
			actualizar: {
				url: "/api/TipoTitulacion/Update"
			},
			eliminar: {
				url: "/api/TipoTitulacion/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		oferta_formativa:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				},
				id_departamento:{
	                vistaTemplate:"/Plantillas/Editor/vistaColeccion",
	                editorTemplate:"/Plantillas/Select/departamentos?clave=id_departamento&texto=nombre",
	                nombre:{
	                    spanish:"Departamento",
	                    basque:"Departamentua"
	                },
                	coleccion:[],
                	leer:{
	                    url:"/api/Departamentos/Get",
	                    crearElemento:function(depart) {
	                        return {clave: depart.id_departamento, valor: depart.nombre};
                    	}
                	},
	                validar:function(id_departamento){
	                    return{
	                        valido:typeof id_departamento !== "undefined" && id_departamento > 0,
	                        mensaje:"Por favor, seleccione un departamento"
	                    };
                	}
            	},
            	
				id_tipo_titulacion:{
	                vistaTemplate:"/Plantillas/Editor/vistaColeccion",
	                editorTemplate:"/Plantillas/Select/tipo_titulacion?clave=id_tipo_titulacion&texto=nombre",
	                nombre:{
	                    spanish:"Tipo de Titulación",
	                    basque:"Titulazio mota"
	                },
	                coleccion:[],
	                leer:{
	                    url:"/api/TipoTitulacion/Get",
	                    crearElemento:function(tipo){
	                        return {clave:tipo.id_tipo_titulacion,valor:tipo.nombre};
	                    }
	                },
	                validar:function(id_tipo){
	                    return {
	                        valido:typeof id_tipo !== "undefined" && id_tipo > 0,
	                        mensaje:"Por favor, seleccione un tipo de titulación"
	                    };
	                }
	            }
				},
				
			leer: {
				url: "/api/OfertaFormativa/Get"
			},
			insertar: {
				url: "/api/OfertaFormativa/Insert"
			},
			actualizar: {
				url: "/api/OfertaFormativa/Update"
			},
			eliminar: {
				url: "/api/OfertaFormativa/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
			},
		
			pais:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				}
			},
			leer: {
				url: "/api/Paises/Get"
			},
			insertar: {
				url: "/api/Paises/Insert"
			},
			actualizar: {
				url: "/api/Paises/Update"
			},
			eliminar: {
				url: "/api/Paises/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		
			provincias:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				}
			},
			leer: {
				url: "/api/Provincias/Get"
			},
			insertar: {
				url: "/api/Provincias/Insert"
			},
			actualizar: {
				url: "/api/Provincias/Update"
			},
			eliminar: {
				url: "/api/Provincias/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		
			localidades:{
			columnas: {
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar",
					nombre: {
						spanish:"nombre",
						basque:"izena"
					}
				},
				
				id_provincia: {
					vistaTemplate: "/Plantillas/Editor/vistaColeccion",
					editorTemplate: "/Plantillas/Select/provincias?clave=id_provincia&texto=nombre",
					coleccion: [],
					leer: {
						url: "/api/Provincias/Get",
						crearElemento: function(provincia){
							return { clave:provincia.id_provincia, valor:provincia.nombre};
						}
					},
					
					nombre: {
						spanish: "Provincia",
						basque: "Probintzia"
					}
					

				}
				
			},
			leer: {
				url: "/api/Localidades/Get"
			},
			insertar: {
				url: "/api/Localidades/Insert"
			},
			actualizar: {
				url: "/api/Localidades/Update"
			},
			eliminar: {
				url: "/api/Localidades/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		},
		
		profesores:{
			columnas: {
            nombre:{
                nombre:{
                    spanish:"nombre",
                    basque:"izena"
                },
                vistaTemplate:"/Plantillas/Editor/vistaEstandar",
                editorTemplate:"/Plantillas/Editor/editorEstandar",
                validar:function(nombre){
                    return {
                        valido:typeof nombre !== "undefined" && nombre.trim && nombre.trim() !== "",
                        mensaje:"El campo nombre es obligatorio"
                    }
                }
            },
            apellido:{
                nombre:{
                    spanish:"Primer Apellido",
                    basque:"Lehen Abizena"
                },
                vistaTemplate:"/Plantillas/Editor/vistaEstandar",
                editorTemplate:"/Plantillas/Editor/editorEstandar",
                validar:function(nombre){
                    return {
                        valido:typeof nombre !== "undefined" && nombre.trim && nombre.trim() !== "",
                        mensaje:"El campo nombre es obligatorio"
                    }
                }
            },
            apellido2:{
                nombre:{
                    spanish:"bigarren abizena",
                    basque:"segundo apellido"
                },
                vistaTemplate:"/Plantillas/Editor/vistaEstandar",
                editorTemplate:"/Plantillas/Editor/editorEstandar"
            },
            email:{
                nombre:{
                    spanish:"email",
                    basque:"emaila"
                },
                vistaTemplate:"/Plantillas/Editor/vistaEstandar",
                editorTemplate:"/Plantillas/Editor/editorEstandar",
                validar:function(nombre){
                    return {
                        valido:typeof nombre !== "undefined" && nombre.trim && nombre.trim() !== "",
                        mensaje:"El campo nombre es obligatorio"
                    }
                }
            },
            id_departamento:{
                vistaTemplate:"/Plantillas/Editor/vistaColeccion",
                editorTemplate:"/Plantillas/Select/departamentos?clave=id_departamento&texto=nombre",
                nombre:{
                    spanish:"Departamento",
                    basque:"Departamentua"
                },
                coleccion:[],
                leer:{
                    url:"/api/Departamentos/Get",
                    crearElemento:function(depart) {
                        return {clave: depart.id_departamento, valor: depart.nombre};
                    }
                },
                validar:function(id_departamento){
                    return{
                        valido:typeof id_departamento !== "undefined" && id_departamento > 0,
                        mensaje:"Por favor, seleccione un departamento"
                    }
                }
            },
            id_rol:{
                vistaTemplate:"/Plantillas/Editor/vistaColeccion",
                editorTemplate:"/Plantillas/Select/roles?clave=id_rol&texto=nombre",
                nombre:{
                    spanish:"Rol",
                    basque:"Rola"
                },
                coleccion:{1:"User",2:"Manager",3:"Admin"},
                validar:function(id_rol){
                    return{
                        valido:typeof id_rol !== "undefined" && id_rol > 0,
                        mensaje:"Por favor, seleccione un rol"
                    }
                }
            }
        },
            leer:{
                url:"/api/Profesores/Get"
            },
            insertar:{
                url:"/api/Profesores/Insert"
            },
            actualizar:{
                url:"/api/Profesores/Update"
            },
            eliminar:{
                url:"/api/Profesores/Delete"
            },
			leer: {
				url: "/api/Profesores/Get"
			},
			insertar: {
				url: "/api/Profesores/Insert"
			},
			actualizar: {
				url: "/api/Profesores/Update"
			},
			eliminar: {
				url: "/api/Profesores/Delete"
			},
			paginacion: {
				pageSizes: {
					valores: $scope.resultadosXpagina,
					seleccionado: $scope.resultadosXpagina[0]
				},
				pagina: 1
			}
		}
		
		
		
			
	};

})

.controller("busquedaOfertas",["$http","$scope",function($http,$scope){

		$scope.filtros ={
			
		};
		var filtrosAnteriores = sessionStorage.getItem("filtrosOfertas");
		if(filtrosAnteriores !== null){
			$scope.filtros = JSON.parse(filtrosAnteriores);
		}
		$scope.buscar = function(){
			sessionStorage.setItem("filtrosOfertas",
				JSON.stringify($scope.filtros));
			$http({
				url:"/api/Ofertas/Get/",
				method: "POST",
				data:$.param({filtros: JSON.stringify($scope.filtros),
							  resultadosPorPagina: typeof resultadosPorPagina !== "undefined"?resultadosPorPagina:null,
							  pagina: typeof pagina !== "undefined"?pagina:null}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){ 
				/* asigna la respuesta a la colección que muestras en el ng-
				repeat*/
				$scope.ofertas = respuesta.data.data;
				},
				function(error){
					alert(error.data?error.data:error);
				}
			);
		};

		$scope.buscar();
		}])

.controller("detalleOferta", ["$http", "$scope", "$routeParams", function($http, $scope, $routeParams){
		$scope.idOferta = $routeParams.id_oferta;
		if($scope.idOferta != 0){
			$http({url: "/api/Ofertas/getById/" +$scope.idOferta})
			.then(
				function(respuesta){
					$scope.oferta = respuesta.data[0];
					$http({
						url:"/api/Conocimientos/GetFromOferta/" + $scope.oferta.id_oferta
					})
					.then(function(respuestaConocimientos){
						$scope.oferta.conocimientos = respuestaConocimientos.data || respuestaConocimientos.data.data;
					},function(error){
						alert(error.data || error);
					});
				},
				function(error){
					alert(error.data?error.data:error);
				}
				)
		}

		$scope.guardar = function(){
			$http({url: "/api/Ofertas/Guardar", 
				method: "POST", 
				data: $.param($scope.oferta),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					window.location = "#!/" + $scope.idOferta;
				},
				function(error){
					alert(error.data?error.data:error);
				}
				)
		}
		
}])
.controller("controladorDatosProfesor", ["$http", "$scope", "$location", function($http, $scope, $location){
	function mostrarMensajeError(mensaje){
		while(angular.isObject(mensaje)){
				mensaje=mensaje.error || mensaje.data || mensaje.mensaje;
		}
			$scope.ventana.establecerTitulo("ERROR");
			$scope.ventana.establecerContenido(mensaje);
			$scope.ventana.establecerBotones([
					{
						texto:"aceptar",
						accion:function(){
							$scope.ventana.cerrar();
						}
					}
				]);
			$scope.ventana.abrir();
			$scope.ventana.centrar();
	}
	$http({url: "/api/Profesores/GetActual"})
	.then(
		function(respuesta){
			var user = respuesta.data;
			var roles = {1: "usuario", 2:"manager", 3:"administrador"};
			$scope.nombreCompleto = user.nombre + " " + user.apellido + " " + user.apellido2;
			$scope.email = user.email;
			$scope.rol = roles[user.id_rol];
			$scope.usuario = user;
			$http({url: "/api/Departamentos/getById/" + user.id_departamento})
			.then(
				function(respuesta){
					$scope.departamento = respuesta.data.nombre;
				},
				function(error){
					mostrarMensajeError(error);
				}
			);
		},
		function(error){
			mostrarMensajeError(error);
		}
		)

	$scope.guardar = function(){
		$http({url: "/api/Profesores/GuardarPerfil", 
				method: "POST", 
				data: $.param($scope.usuario),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					$location.path("/");
				},
				function(error){
					mostrarMensajeError(error);
				}
				)
	}

}])
.controller("controladorDatosAlumno", ["$http", "$scope", "$location", function($http, $scope, $location){
	$http({url: "/api/Alumnos/GetActual"})
	.then(
		function(respuesta){
			var user = respuesta.data;
			$scope.nombreCompleto = user.nombre + " " + user.apellido + " " + user.apellido2;
			$scope.email = user.email;
			$scope.usuario = user;
			$scope.alumno = user;
			if(typeof $scope.usuario.id_localidad !== "undefined" && $scope.usuario.id_localidad){
				$http({
					url:"/api/Localidades/GetById/" + $scope.usuario.id_localidad
				})
				.then(
				function(respuesta){
					$scope.provincia = respuesta.data.provincia;
					$scope.localidad = respuesta.data.localidad;
					$scope.id_provincia = $scope.provincia.id_provincia;
					$scope.cargarLocalidades();
				},
				function(error){

				})
				
			}
		},

		function(error){
			alert(error.data?error.data:error);
		}
		)
	$http({url:"/api/Alumnos/CargarImagen"})
	.then(
		function(respuesta){
			$scope.imagen = respuesta.data.imagen;
		},
		function(error){
			alert(error.data?error.data:error);
		}
		)

	$scope.guardar = function(){
		$http({url: "/api/Alumnos/GuardarPerfil", 
				method: "POST", 
				data: $.param($scope.usuario),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					$location.path("/");
				},
				function(error){
					alert(error.data?error.data:error);
				}
				)
	}

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

}])
.controller("controladorClaveProfesor",["$http", "$scope", "$location", function($http, $scope, $location){
	$scope.usuario = {};
	$scope.cambiarClave = function(){
		$scope.formPerfil.$setSubmitted(true);
		if($scope.formPerfil.$valid){
			$http({url: "/api/Profesores/CambiarClave", 
					method: "POST", 
					data: $.param($scope.usuario),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
			.then(
					function(respuesta){
						$scope.ventana.establecerTitulo("clave_cambiada");
						$scope.ventana.establecerContenido("clave_cambiada_cuerpo");
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
								$location.path("/");
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();

						
					},
					function(error){
						$scope.ventana.establecerTitulo("error");
						var mensaje = error.data;
						if(angular.isArray(error.data) || angular.isObject(error.data)){
							mensaje = "";
							for(var clave in error.data){
								mensaje += error.data[clave] + "\r";
							}
						}
						$scope.ventana.establecerContenido(mensaje);
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();
					}
					)
		}
	}
}])

.controller("controladorProfesorBuscarAlumno",["$http", "$scope", "$location", function($http, $scope, $location){
	$scope.alumnos = [];
	$scope.filtros = {};
	$scope.buscar = function(){
		$http({
			url:"/api/Alumnos/Buscar",
			method: "POST",
			data:$.param({filtros: $scope.filtros}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}	
		})
		.then(function(respuesta){
			$scope.alumnos = respuesta.data;
		},function(error){
			debugger;
		});
	};
	$scope.buscar();
}])
.controller("controladorInvitarAlumnos",["$http", "$scope",function($http, $scope){
	$scope.cargarEmails = function(){
		enviar($scope.emails);
	}
	function mostrarError(error){
		var mensaje = error;
		while(angular.isObject(error)){
			error = error.error || error.mensaje || error.data;
		}
		$scope.ventana.establecerTitulo("Error");
		$scope.ventana.establecerContenido(mensaje);
		$scope.ventana.establecerBotones([
			{
				texto:"aceptar",
				accion:function(){
					$scope.ventana.cerrar();
				}
			}
			]);
		$scope.ventana.abrir();
		$scope.ventana.centrar();
	}
	var enviar = function(text){
		$http({
					url:"/api/Alumnos/Invitar/",
					method:"POST",
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data:$.param({emails:text})
				})
				.then(function(respuesta){
					var errores = respuesta.data.errores;
					var respuesta = "Se han enviado añadido todos los alumnos";
					if(typeof errores !== "undefined" && errores.length !== 0){
						respuesta = "No se ha podido añadir a los siguientes alumnos:";
						var esPrimero = true;
						for(var i in errores){
							if(!esPrimero){
								respuesta+=",";
							}
							respuesta+= " " + errores[i];
							esPrimero = false;
						}
					}
					var ventana = $scope.ventana;
					ventana.establecerTitulo("invitar_titulo");
					ventana.establecerContenido(respuesta);
					ventana.establecerBotones([{
						texto:"aceptar",
						accion:function(){
							ventana.cerrar();
						}
					}]);
					ventana.abrir();
					ventana.centrar();
				},
				function(error){
					debugger;
				});
	}
	$scope.cargarCSV = function(){
			if($scope.files.length>0){
			var reader = new FileReader();
			reader.onload = function(evt){
				var text = evt.target.result;
				enviar(text);
			};
			reader.readAsText($scope.files[0]);
		}
	};
}])
.controller("controladorDetalleAlumno",["$http","$scope","$routeParams",function($http,$scope,$routeParams){
	$http({
		url:"/api/Alumnos/GetById/"+$routeParams.id_alumno
	})
	.then(
		function(respuesta){
			$scope.alumno = respuesta.data.data[0];
			$http({
					url: "/api/Experiencias/Get/" + $scope.alumno.id_alumno
				})
				.then(
					function(respuesta){
						$scope.experiencias = respuesta.data.data;
				},
					function(error){
						$scope.ventana.alerta("error",error.data?error.data:error,function(){});
					});
			$http({
				url:"/api/FormacionAcademica/Get/" + $scope.alumno.id_alumno
			})
			.then(
				function(respuesta){
					$scope.formaciones_academicas = respuesta.data.data;
				},
				function(error){
					console.log(JSON.stringify(error));
				}
			);
			$http({
				url:"/api/FormacionComplementaria/Get/" + $scope.alumno.id_alumno
			})
			.then(
				function(respuesta){
					$scope.formaciones_complementarias = respuesta.data.data;
				},
				function(error){
					console.log(JSON.stringify(error));
				}
			);
			$http({
				url:"/api/Idioma/Get/" + $scope.alumno.id_alumno
			})
			.then(
				function(respuesta){
					$scope.idiomas = respuesta.data.data;
				},
				function(error){
					console.log(JSON.stringify(error));
				}
			);
		},
		function(error){
			debugger;
		}
	);
}])
.controller("detalleOfertaAlumno", ["$http","$scope","$routeParams",function($http,$scope,$routeParams){
	$scope.apuntarse = function(){
		$http({
			url:"/api/Ofertas/Apuntar",
			method:"POST",
			data:$.param({
				id_oferta:$scope.oferta.id_oferta
			}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(
			function(respuesta){
				$scope.apuntado = respuesta.data;
			},
			function(error){
				
			}
		);
	};
	$http({
		url:"/api/Ofertas/GetbyId/"+$routeParams.id_oferta
	}).
	then(
		function(respuesta){
			$scope.oferta = respuesta.data[0];
			$http({
				url:"/api/Ofertas/Candidatura",
				params: {
					id_oferta: $scope.oferta.id_oferta
				}
			})
			.then(
				function(respuesta){
					$scope.apuntado = respuesta.data;
				},
				function(error){
					
				}
			);
			
		},
		function(error){
			
		}
	);
	
}])

.controller("controladorProfesorBuscarEmpresa",["$http", "$scope", "$location", function($http, $scope, $location){
	$scope.empresas = [];
	$scope.filtros = {};
	$scope.cargarLocalidades = function(){
                   if($scope.filtros.id_provincia){
                        $http({
                            url:"/api/Localidades/GetDeProvincia/"+$scope.filtros.id_provincia
                        }).then(
                            function(respuesta){
                                $scope.localidades = respuesta.data;
                            },
                            function(error){
                                mostrarMensajeError(error);
                            }
                        );
                    }
                };
	$scope.buscar = function(){
		$http({
			url:"/api/Empresas/Buscar",
			method: "POST",
			data:$.param({filtros: $scope.filtros}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}	
		})
		.then(function(respuesta){
			$scope.empresas = respuesta.data;
		},function(error){
		});
	};
	$scope.comprobarPais = function(){
		if($scope.filtros.id_pais == $scope.espana.id_pais){
			$scope.provinciasDisabled = false;
		}else{
			$scope.provinciasDisabled = true;
			$scope.filtros.id_localidad = null;
			$scope.filtros.id_provincia = null;
		}
	};
	$scope.buscar();
	
}])
.controller("controladorAnadirEmpresa",["$http", "$scope", function($http, $scope){0
	$scope.vista = {};
	$scope.init = function(){
		$scope.vista.id_pais = $scope.espana.id_pais;
	}
	$scope.editando = true;
	$scope.ocultar = true;
	$scope.guardar = function(){
		$scope.ocultar = false;
		$scope.form = angular.element("[ng-form='form']").controller('form');
		if($scope.form.$valid){
			$http({
				url: "/api/Empresas/Insert",
				method: "POST",
				data: $.param($scope.vista),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					window.location = "#!/";
				},
				function(error){
					
				}
			);
		}
	};
	$scope.comprobarPais = function(){
		if($scope.vista.id_pais == $scope.espana.id_pais){
			$scope.provinciasDisabled = false;
		}else{
			$scope.provinciasDisabled = true;
			$scope.vista.id_localidad = null;
			$scope.provincia.id_provincia = null;
		}
	};
	$scope.provincia = { id_provincia: 0};
	$scope.cargarLocalidades = function(){
                   if($scope.provincia.id_provincia){
                        $http({
                            url:"/api/Localidades/GetDeProvincia/"+$scope.provincia.id_provincia
                        }).then(
                            function(respuesta){
                                $scope.localidades = respuesta.data;
                            },
                            function(error){
                                mostrarMensajeError(error);
                            }
                        );
                    }
                };

}]).controller("controladorDetalleEmpresa", ["$http", "$scope", "$routeParams", function($http, $scope, $routeParams){
	$scope.id_empresa = $routeParams.id_empresa;
	$http({
		url:"/api/Empresas/GetbyId/" + $scope.id_empresa
	})
	.then(
		function(respuesta){
			$scope.empresa = respuesta.data;
			$scope.provinciasDisabled = $scope.empresa.id_pais != $scope.espana.id_pais;
			if($scope.empresa.id_localidad){
				$http({
					url:"/api/Provincias/GetByLocalidad/"+ $scope.empresa.id_localidad
				})
				.then(function(respuesta){
					$scope.provincia = respuesta.data.provincia;
					$scope.cargarLocalidades();
				},function(error){});
			}
		},
		function(error){
		}
	);
	$scope.editando = false;
	$scope.editar = function(){
		$scope.vista = angular.copy($scope.empresa);
		$scope.editando = true;
	};
	$scope.cancelar = function(){
		$scope.vista = {};
		$scope.editando = false;
	};
	$scope.guardar = function(){
		$scope.form = angular.element("[ng-form='form']").controller('form');
		if($scope.form.$valid){
			$http({
				url: "/api/Empresas/Update",
				method: "POST",
				data: $.param({
					viejo:$scope.empresa,
					nuevo:$scope.vista
				}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					$scope.empresa = respuesta.data;
					$scope.cancelar();
					if($scope.empresa.id_localidad){
						$http({
							url:"/api/Provincias/GetByLocalidad/"+ $scope.empresa.id_localidad
						})
						.then(function(respuesta){
							$scope.provincia = respuesta.data.provincia;
							$scope.cargarLocalidades();
						},
						function(error){
							
						});
					}else{
						$scope.provincia = {};
					}
				},
				function(error){
					
				}
			);
		}
	};
	$scope.comprobarPais = function(){
		if($scope.vista.id_pais == $scope.espana.id_pais){
			$scope.provinciasDisabled = false;
		}else{
			$scope.provinciasDisabled = true;
			$scope.vista.id_localidad = null;
			$scope.provincia.id_provincia = null;
		}
	};
	$scope.provincia = { id_provincia: 0};
	$scope.cargarLocalidades = function(){
                   if($scope.provincia.id_provincia){
                        $http({
                            url:"/api/Localidades/GetDeProvincia/"+$scope.provincia.id_provincia
                        }).then(
                            function(respuesta){
                                $scope.localidades = respuesta.data;
                            },
                            function(error){
                                mostrarMensajeError(error);
                            }
                        );
                    }
                };
}])
.controller("controladorCambiarClaveEmpresa", ["$scope", "$http", "$routeParams", function($scope,$http,$routeParams){
	$scope.ocultar_clave = true;
	$scope.usuario = {id_empresa:$routeParams.id_empresa};
	$scope.cambiarClave = function(){
		if($scope.usuario.nuevaclave === $scope.usuario.repetirclave &&$scope.usuario.nuevaclave && $scope.usuario.nuevaclave.trim()){
			$http({url: "/api/Empresas/CambiarClave", 
					method: "POST", 
					data: $.param($scope.usuario),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
			.then(
					function(respuesta){
						$scope.ventana.establecerTitulo("clave_cambiada");
						$scope.ventana.establecerContenido("clave_cambiada_cuerpo");
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
								$location.path("/");
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();

						
					},
					function(error){
						$scope.ventana.establecerTitulo("error");
						var mensaje = error.data;
						if(angular.isArray(error.data) || angular.isObject(error.data)){
							mensaje = "";
							for(var clave in error.data){
								mensaje += error.data[clave] + "\r";
							}
						}
						$scope.ventana.establecerContenido(mensaje);
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();
					}
					)
		}
		else{
			$scope.formPerfil = {$submitted:true, repetirclave:{$invalid:true}, nuevaclave:{$invalid:true} };
		}
	}
}])
.controller("controladorDatosEmpresa", ["$scope", "$http", function($scope, $http){
	$scope.editando = 0;
	$scope.editar = function(){
		$scope.editando = 1;
		$scope.vista = angular.copy($scope.empresa);		
		$scope.comprobarPais();
		$scope.init();
	};
	$scope.cancelar = function(){
		$scope.editando = 0;
	};
	$scope.mostrarcambiarclave = function(){
		$scope.editando =2;
	};
	$scope.init = function(){
		if($scope.empresa.id_localidad){
				$http({
					url:"/api/Provincias/GetByLocalidad/"+ $scope.empresa.id_localidad
				})
				.then(function(respuesta){
					$scope.provincia = respuesta.data.provincia;
					$scope.cargarLocalidades();
				},function(error){});
		}
	};
	$scope.guardar = function(){
		$http({
				url: "/api/Empresas/Update",
				method: "POST",
				data: $.param({
					viejo:$scope.empresa,
					nuevo:$scope.vista
				}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			})
			.then(
				function(respuesta){
					$scope.empresa = respuesta.data;
					$scope.cancelar();
					if($scope.empresa.id_localidad){
						$http({
							url:"/api/Provincias/GetByLocalidad/"+ $scope.empresa.id_localidad
						})
						.then(function(respuesta){
							$scope.provincia = respuesta.data.provincia;
							$scope.cargarLocalidades();
						},
						function(error){
							
						});
					}else{
						$scope.provincia = {};
					}
				},
				function(error){
					
				}
			);
	};
	$scope.comprobarPais = function(){
		if($scope.vista.id_pais == $scope.espana.id_pais){
			$scope.provinciasDisabled = false;
		}else{
			$scope.provinciasDisabled = true;
			$scope.vista.id_localidad = null;
			$scope.provincia.id_provincia = null;
		}
	};
	$scope.provincia = { id_provincia: 0};
	$scope.cargarLocalidades = function(){
       if($scope.provincia.id_provincia){
            $http({
                url:"/api/Localidades/GetDeProvincia/"+$scope.provincia.id_provincia
            }).then(
                function(respuesta){
                    $scope.localidades = respuesta.data;
                },
                function(error){
                    mostrarMensajeError(error);
                }
            );
        }
     };
	
}])
.controller("detalleOfertaEmpresa" , ["$scope", "$http", "$routeParams", function($scope, $http, $routeParams){
	$scope.id_oferta = $routeParams.id_oferta;
	if($scope.id_oferta == 0){
		$scope.editando = true;
		$scope.vista = {};
	}
	
	if($scope.id_oferta != 0){
		$http({url: "/api/Ofertas/getById/" +$scope.id_oferta})
			.then(
				function(respuesta){
					$scope.oferta = respuesta.data[0];
					$http({
						url:"/api/Conocimientos/GetFromOferta/" + $scope.oferta.id_oferta
					})
					.then(function(respuestaConocimientos){
						$scope.oferta.conocimientos = respuestaConocimientos.data || respuestaConocimientos.data.data;
					},function(error){
						alert(error.data || error);
					});
				},
				function(error){
					alert(error.data?error.data:error);
				}
			);
	}
	
	$scope.editar = function(){
		$scope.vista = angular.copy($scope.oferta);
		$scope.editando = true;
	};
	
	$scope.cancelar = function(){
		if($scope.id_oferta == 0){
			window.location = "#!/";
		}
		else{
			$scope.editando = false;
		}
	};
	
	$scope.guardar = function(){
		$http({
			url :"/api/Ofertas/Guardar",
			data : $.param($scope.vista),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			method: "POST"
		})
		.then(
			function(respuesta){
				$scope.oferta = respuesta.data;
				if($scope.id_oferta == 0){
					window.location = "#!/" + $scope.oferta.id_oferta;
				}
				else{
					$http({
						url:"/api/Conocimientos/GetFromOferta/" + $scope.oferta.id_oferta
					})
					.then(function(respuestaConocimientos){
						$scope.oferta.conocimientos = respuestaConocimientos.data || respuestaConocimientos.data.data;
					},function(error){
						alert(error.data || error);
					});
					$scope.cancelar();
				}
			},
			function(error){
				
			}
		);
	};
	
	function cargarAlumnos(){
		if($scope.id_oferta){
			$http({
				url: "/api/Ofertas/Candidatos/" + $scope.id_oferta
			})
			.then(function(respuesta){
				$scope.alumnos = respuesta.data;
			},
			function(error){
				
			});
		}
	}
	
	cargarAlumnos();
	
}])
.controller("controladorClaveAlumno",["$http", "$scope", "$location", function($http, $scope, $location){
	$scope.usuario = {};
	$scope.cambiarClave = function(){
		$scope.formPerfil.$setSubmitted(true);
		if($scope.formPerfil.$valid){
			$http({url: "/api/Alumnos/CambiarClave", 
					method: "POST", 
					data: $.param($scope.usuario),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
			.then(
					function(respuesta){
						$scope.ventana.establecerTitulo("clave_cambiada");
						$scope.ventana.establecerContenido("clave_cambiada_cuerpo");
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
								$location.path("/");
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();

						
					},
					function(error){
						$scope.ventana.establecerTitulo("error");
						var mensaje = error.data;
						if(angular.isArray(error.data) || angular.isObject(error.data)){
							mensaje = "";
							for(var clave in error.data){
								mensaje += error.data[clave] + "\r";
							}
						}
						$scope.ventana.establecerContenido(mensaje);
						$scope.ventana.establecerBotones([{
							accion:function(){
								$scope.ventana.cerrar();
							}, 
							texto: "aceptar"
							}
						]);
						$scope.ventana.abrir();
						$scope.ventana.centrar();
					}
				)
	}
	}
}]);
