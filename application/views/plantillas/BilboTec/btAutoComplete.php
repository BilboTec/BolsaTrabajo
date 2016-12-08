<div class="auto-complete">
    <ul>
        <li ng-repeat="v in valor">
            {{ v[indiceTexto] }}
            <ul>
                <li ng-repeat="i in [0,1,2]" ng-class="v.puntuacion>=i?'activo':'inactivo'" ng-click="v.puntuacion=i">
                    &nbsp;
                </li>
            </ul>
        </li>
    </ul>
    <input type="text" ng-model="texto" ng-change="buscar()"/>
</div>
<ul class="dropdown">
    <li ng-repeat="elem in vista">{{ elem[indiceTexto] }}</li>
</ul>