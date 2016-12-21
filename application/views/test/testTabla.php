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
                coleccion:["User","Manager","Admin"],
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