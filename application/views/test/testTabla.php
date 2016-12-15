<style>
    
</style>
<div ng-controller="testController">
    <div bt-tabla ng-model="filas" bt-config="configuracion"/>
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
        columnas: {
            nombre:{
                vistaTemplate:"Plantillas/Editor/vistaEstandar",
                editorTemplate:"Plantillas/Editor/editorEstandar"
            }
        },
            leer:{
                url:"/api/Conocimientos/Get"
            },
            insertar:{
                url:"/api/Conocimientos/Insert"
            },
            actualizar:{
                url:"/api/Conocimientos/Update"
            },
            eliminar:{
                url:"/api/Conocimientos/Delete"
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