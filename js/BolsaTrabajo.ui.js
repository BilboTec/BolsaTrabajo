angular.module("BolsaTrabajo.ui")
.directive("btInputLabel",function(){
    return{
        restrict: "A",
        scope:{
            valor:"=btModel",
            label:"=btLabel",
            required:"=ngRequired"
        },
        templateUrl:function(elem,attrs){
            var url = "/Plantillas/Get/btInputLabel?type="
                +(attrs.type?attrs.type:"text");
            if(attrs.name){
                url+="&name="+attrs.name;
            }
            return url;

        },
        link:function(scope,elem,attr){
            scope.comprobarValor = function(){
                scope.vacio = scope.valor
            }
        }
    };
});