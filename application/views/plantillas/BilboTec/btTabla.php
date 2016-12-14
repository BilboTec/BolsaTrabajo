<table>
    <thead>
        <tr>
            <td>
                <button ng-click="insertar()">Añadir</button>
            </td>
        </tr>
        <tr>
            <th ng-repeat="(columna, config) in configuracion.columnas"
                ng-click="ordenar(columna)" ng-class='configuracion.orden==columna?"orden":"";configuracion.orden.direccion?"asc":"desc"'>{{ columna }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr ng-show="mostrarInsertar">
            <td ng-repeat="(columna,config) in configuracion.columnas"
                ng-include="mostrarInsertar?config.editorTemplate:config.vistaTemplate">
            </td>
            <td><button ng-click="aplicarInsertar()">Actualizar</button><button ng-click="cancelarInsertar()">Cancelar</button></td>
        </tr>
        <tr ng-repeat="fila in filas | orderBy: configuracion.orden:configuracion.direccion">
            <td ng-repeat="(columna,config) in configuracion.columnas"
                ng-include="editandoFila==$parent.$index?config.editorTemplate:config.vistaTemplate">
            </td>
            <td>
                <button ng-click="editar($index)" ng-show="editandoFila!=$index">Editar</button>
                <button ng-show="editandoFila!=$index" ng-click="eliminar($index)">Eliminar</button>
                <button ng-show="editandoFila==$index" ng-click="aplicar()">Actualizar</button>
                <button ng-show="editandoFila==$index" ng-click="editandoFila=-1">Cancelar</button>
            </td>
        </tr>
    </tbody>
</table>