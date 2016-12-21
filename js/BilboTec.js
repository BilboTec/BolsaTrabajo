angular.module("BilboTec.ui",[]);
angular.module("BilboTec",["BilboTec.ui", "ngRoute"])
.config(function($routeProvider){
	$routeProvider.when("/", {
		templateUrl : function(a, b, c){return "/Profesor/BuscarOferta";}
	}).when("/:id_oferta", {
		templateUrl : "/Profesor/DetalleOferta"
	});
})
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
				nombre: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar"
				},
				apellido: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar"
				},
				apellido2: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar"
				},
				id_departamento: {
					vistaTemplate: "/Plantillas/Editor/vistaColeccion",
					editorTemplate: "/Plantillas/Select/departamentos?clave=id_departamento&texto=nombre",
					coleccion: [],
					leer: {
						url: "/api/Departamentos/Get",
						crearElemento: function(departamento){
							return { clave:departamento.id_departamento, valor:departamento.nombre};
						}
					},
					
					nombre: {
						spanish: "Departamento",
						basque: "Departamentua"
					}
					

				},
				id_rol: {
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Editor/editorEstandar"
				}
				
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
	
});
