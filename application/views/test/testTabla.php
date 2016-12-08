<style>
    
</style>
<div ng-controller="testController">
    <div bt-tabla ng-model="filas" bt-config="configuracion"/>
</div>
<script>
    angular.module("BolsaTrabajo").controller("testController",function($scope){
       $scope.filas = [
           {id:1,nombre:"Josu",apellido:"Astigarraga"},
           {id:2,nombre:"Yanire",apellido:"Lopez"}
       ];
        $scope.configuracion = {
        columnas: {
            id:{
                vistaTemplate:"Plantillas/Editor/vistaEstandar",
                    editorTemplate
            :
                "Plantillas/Editor/editorEstandar"
            }
            ,
            nombre:{
                vistaTemplate:"Plantillas/Editor/vistaEstandar",
                    editorTemplate
            :
                "Plantillas/Editor/editorEstandar"
            }
        ,
            apellido:{
                vistaTemplate:"Plantillas/Editor/vistaEstandar",
                    editorTemplate
            :
                "Plantillas/Editor/editorEstandar"
            }
        }
    };
    });
</script>