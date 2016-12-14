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
                <button ng-show="editandoFila==$index" ng-click="cancelar()">Cancelar</button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{configuracion.columnas.length}}">
                <div class="paginacion">
                    <div ng-repeat="pagina in crearControlesPaginacion()" ng-click="irPagina(pagina.numero)">{{ pagina.numero }}</div>
                    <select ng-init="configuracion.paginacion.pageSizes.seleccionado=configuracion.pageSizes.seleccionado||configuracion.paginacion.pageSizes.valores[0]"
                            ng-model="configuracion.paginacion.pageSizes.seleccionado"
                            ng-change="leer()"
                            ng-options="rPp.texto for rPp in configuracion.paginacion.pageSizes.valores track by rPp.valor"></select>
                </div>
            </td>
        </tr>
    </tfoot>
</table>