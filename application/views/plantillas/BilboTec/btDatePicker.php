<div class="editor">
    <input type="hidden" value="{{valor}}">
    <span id="texto" contenteditable>dd/mm/yyyy</span>
    <span class= "btn-date btn" ng-click="abrir()"><img src="/imagenes/anadir.png"></span>
</div>
<div ng-show="abierto" class="desplegable" ng-switch="estado">
    <div class="panel" ng-switch-when="2">
        <div class="barra">
            <span ng-click="cambiarAniosMostrados($event,-10)" class="btn btn-mini">&lt;&lt;</span>
            <span>{{anioInicio}} - {{anioFin}}</span>
            <span ng-click="cambiarAniosMostrados($event,10)" class="btn btn-mini">&gt;&gt;</span>
        </div>
        <p class="btn btn-select" ng-repeat="a in anios" ng-click="establecerAnio($event,a)">{{a}}</p>
    </div>
    <div class="panel" ng-switch-when="1">
        <div class="barra">
            <span ng-click="cambiarAnio($event,-1)" class="btn btn-mini">&lt;&lt;</span>
            <span class="btn" ng-click="mostrarAnios($event)">{{anio}}</span>
            <span ng-click="cambiarAnio($event,1)" class="btn btn-mini">&gt;&gt;</span>
        </div>
        <p class="btn btn-select" ng-repeat="mes in mesesCompletos" ng-click="seleccionarMes($event,$index)">{{mes | btLocale}}</p>
    </div>
    <div class="panel" ng-switch-default>
        <div class="barra">
            <span class="btn btn-mini" ng-click="cambiarMes(-1)">&lt;&lt;</span>
            <span class="btn" ng-click="mostrarMeses($event)">{{ meses[mes] | btLocale }} de {{ anio }}</span>
            <span class="btn btn-mini" ng-click="cambiarMes(1)">&gt;&gt;</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th ng-repeat="dia in diasSemana">{{dia | btLocale }}</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="semana in semanas">
                    <td class="btn" ng-class="(activo?'activo':'')" ng-repeat="dia in semana" ng-click="establecerFecha(dia)">{{dia["dd"]}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>