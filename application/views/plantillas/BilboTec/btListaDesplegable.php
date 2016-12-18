<div class="bt-lista-desplegable valor" ng-click="desplegar()">
    <span class="bt-lista-desplegable-contenedor">{{ conf.texto(valor) }}</span><span class="btn">V</span> </div>
<ul class="bt-lista-desplegable desplegable" ng-show="desplegado">
    <li ng-repeat="elemento in elementos track by $index" ng-click="seleccionar($index)">{{ conf.texto(elemento)  }}</li>
</ul>