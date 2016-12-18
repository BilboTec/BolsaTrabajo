angular.module("BilboTec.ui",[]);
angular.module("BilboTec",["BilboTec.ui"])
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
					editorTemplate: "/Plantillas/Editor/editorEstandar"
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
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Select/departamentos"
				},
				id_tipo_titulacion:{
					vistaTemplate: "/Plantillas/Editor/vistaEstandar",
					editorTemplate: "/Plantillas/Select/tipo_titulacion"
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
		}
	};
	$scope.establecerConfiguracion = function(configuracion){
		$scope.configuracion = $scope.configuraciones[configuracion];
		$scope.leer();
	};
	
});
