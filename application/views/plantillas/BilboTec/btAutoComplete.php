<div><input type="text" ng-model="textoBusqueda" ng-change="buscar()"></div>
<ul class="dropdown">
    <li ng-repeat="resultado in resultadosFiltrados">{{ resultado[texto] }}</li>
</ul>
<ul>
    <li ng-repeat="valor in valores">
        {{ valor[texto] }}
        <ul>
            <li ng-if="hayPuntuaciones"  ng-repeat="puntuacion in [1,2,3]" ng-class="v.puntuacion>=i?'activo':'inactivo'" ng-click="establecerPuntuacion($index,puntuacion)">
                &nbsp;
            </li>
            <li class="btn" ng-click="eliminar($index)">&times;</li>
        </ul>
    </li>
</ul>
<div bt-window="ventana"></div>