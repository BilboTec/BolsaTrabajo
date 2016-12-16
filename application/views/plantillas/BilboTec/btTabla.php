<table>
    <thead>
        <tr>
            <td>
                <div class="cargando" ng-class="cargando?'activo':''"></div>
                <button ng-click="insertar()">Añadir</button>
            </td>
        </tr>
        <tr>
            <th ng-repeat="(columna, config) in configuracion.columnas"
                ng-click="ordenar(columna)">
                <span  ng-class='configuracion.orden==columna?"orden":"";configuracion.orden.direccion?"asc":"desc"'>
                    {{ (config.nombre || columna) | uppercase  }}</span><span class="error-validacion">{{ config.error }}</span> </th>
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
            <td colspan="1000">
                <div class="paginacion">
                    <div class="controles-paginas">
                    <button class="btn" ng-disabled="configuracion.paginacion.pagina<=1" ng-click="irPagina(1)">&lt;&lt;</button>
                        <button class="btn" ng-disabled="configuracion.paginacion.pagina<=1" ng-click="cambiarPagina(-1)">&lt;</button>
                    <input type="number" ng-change="leer()" class="marcador-pagina" min="1" max="{{configuracion.paginacion.total}}"  ng-model="configuracion.paginacion.pagina"/>
                    /{{ configuracion.paginacion.total || 1 }}
                        <button class="btn" ng-click="cambiarPagina(1)" ng-disabled="configuracion.paginacion.total<=configuracion.paginacion.pagina">&gt;</button>
                        <button class="btn" ng-disabled="configuracion.paginacion.total<=configuracion.paginacion.pagina"
                        ng-click="irPagina(configuracion.paginacion.total)">&gt;&gt;</button>
                    </div>
                    <div class="resultados-por-pagina">
                        Resultados por página
                        <select ng-init="configuracion.paginacion.pageSizes.seleccionado=configuracion.paginacion.pageSizes.seleccionado||configuracion.paginacion.pageSizes.valores[0]"
                            ng-model="configuracion.paginacion.pageSizes.seleccionado"
                            ng-change="leer()"
                            ng-options="rPp.texto for rPp in configuracion.paginacion.pageSizes.valores track by rPp.valor"></select>
                    </div>
                    <div>Actualizar<button class="btn" ng-click="leer()">&times;</button></div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>