<div ng-controller="testDesplegableController">
    <div bt-lista-desplegable="desplegable" ng-model="valor" bt-config="configuracion"></div>
</div>
<script>
    angular.module("BilboTec")
        .controller("testDesplegableController",function($scope){
            $scope.configuracion = {
                texto:function(departamento){
                    return departamento? departamento.nombre:undefined;
                },
                leer:{
                    url:"/api/Departamentos/Get",
                    set:function(respuesta){
                        return respuesta.data.data;
                    }
                }
            };
        });
</script>