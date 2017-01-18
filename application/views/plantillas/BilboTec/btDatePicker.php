<div class="editor">
    <input type="hidden" value="{{valor}}">
    <span id="texto" contenteditable>dd/mm/yyyy</span>
    <span class= "btn-date btn" ng-click="abrir()"><img src="/imagenes/anadir.png"></span>
</div>
<div ng-show="abierto" class="desplegable">
    <div class="barra">
        <span class="btn btn-mini" ng-click="cambiarMes(-1)">&lt;&lt;</span>
        <span>{{ meses[mes] }} de {{ anio }}</span>
        <span class="btn btn-mini" ng-click="cambiarMes(1)">&gt;&gt;</span>
    </div>
    <table>
        <thead>
            <tr>
                <th ng-repeat="dia in diasSemana">{{dia}}</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="semana in semanas">
                <td class="btn" ng-class="(activo?'activo':'')" ng-repeat="dia in semana" ng-click="establecerFecha(dia)">{{dia["dd"]}}</td>
            </tr>
        </tbody>
    </table>
</div>