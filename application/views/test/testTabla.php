<style>
    
</style>
<div ng-controller="testController">
    <div bt-tabla ng-model="filas" bt-config="configuracion" bt-set-config="establecerConfiguracion"/>
</div>
<script>
    angular.module("BilboTec").controller("testController",function($scope){
        $scope.resultadosPorPagina = [
            {
                texto:"5",
                valor:5
            },
            {
                texto:"10",
                valor:10
            },
            {
                texto:"20",
                valor:20
            },
            {
                texto:"50",
                valor:50
            },
            {
                texto: "100",
                valor: 100
            }];
       $scope.filas = [];
        $scope.configuracion = {
        lang:angular.element("html").attr("bt-lang")||"spanish",
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
                    }
                }
            }
        },
            leer:{
                url:"/api/OfertaFormativa/Get"
            },
            insertar:{
                url:"/api/OfertaFormativa/Insert"
            },
            actualizar:{
                url:"/api/OfertaFormativa/Update"
            },
            eliminar:{
                url:"/api/OfertaFormativa/Delete"
            },
            paginacion:{
                pageSizes:{
                    valores:$scope.resultadosPorPagina,
                    seleccionado:$scope.resultadosPorPagina[0]
                },
                nBotones: 5,
                pagina:1
            }
    };
    });
</script>