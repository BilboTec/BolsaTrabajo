<ul class="lista-valores">
    <li class="valor" ng-repeat="valor in valores track by $index">
        {{ valor[texto] }}
            <span ng-if="hayPuntuaciones"  ng-repeat="puntuacion in [1,2,3]" ng-class="v.puntuacion>=i?'activo':'inactivo'" ng-click="establecerPuntuacion($index,puntuacion)">
                &nbsp;
            </span>
            <span class="btn btn-cerrar" ng-click="eliminar($index)">&times;</span>
    </li>
</ul>
<input type="text" ng-model="textoBusqueda" ng-change="buscar()" ng-focus="abrir()">
<ul class="dropdown" ng-show="abierto">
    <li class="btn" ng-repeat="resultado in resultadosFiltrados"
    ng-click="add(resultado)">{{ resultado[texto] }}</li>
</ul>
<div bt-window="ventana"></div>