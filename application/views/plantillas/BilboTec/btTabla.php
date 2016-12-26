<div bt-window="btWindow"></div>
<table ng-init="lang='<?php echo (isset($lang)?$lang:"spanish"); ?>'">
    <thead>
        <tr>
            <td>
                <div class="cargando" ng-class="cargando?'activo':''"></div>
                <button title="<?php echo ucfirst($idioma("insertar")); ?>" class="btn btn-tabla btn-insert" ng-click="insertar()"></button>
            </td>
        </tr>
        <tr>
            <th ng-repeat="(columna, config) in configuracion.columnas"
                ng-click="ordenar(columna)">
                <span  ng-class='{orden: configuracion.orden==columna, asc:configuracion.direccion==true}'>
                    {{ (config.nombre[lang||"spanish"] || columna) | uppercase  }} </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr ng-show="mostrarInsertar" class="animation-move">
            <td ng-repeat="(columna,config) in configuracion.columnas"
                ng-include="mostrarInsertar?config.editorTemplate:config.vistaTemplate">
            </td>
            <td><button title="<?php echo ucfirst($idioma("actualizar")); ?>" class="btn btn-tabla btn-aplicar" ng-click="aplicarInsertar()"></button>
                <button title="<?php echo ucfirst($idioma("cancelar")); ?>" class="btn btn-tabla btn-cancelar" ng-click="cancelarInsertar()"></button></td>
        </tr>
        <tr ng-repeat="fila in filas" class="animation-move">
            <td ng-repeat="(columna,config) in configuracion.columnas"
                ng-include="editandoFila==$parent.$index?config.editorTemplate:config.vistaTemplate">
            </td>
            <td>
                <button title="<?php echo ucfirst($idioma("editar")); ?>" class="btn btn-tabla btn-editar" ng-click="editar($index)" ng-show="editandoFila!=$index"></button>
                <button title="<?php echo ucfirst($idioma("eliminar")); ?>" class="btn btn-tabla btn-eliminar" ng-show="editandoFila!=$index" ng-click="eliminar($index)"></button>
                <button title="<?php echo ucfirst($idioma("actualizar")); ?>" class="btn btn-tabla btn-aplicar" ng-show="editandoFila==$index" ng-click="aplicar()"></button>
                <button title="<?php echo ucfirst($idioma("cancelar")); ?>" class="btn btn-tabla btn-cancelar"  ng-show="editandoFila==$index" ng-click="cancelar()"></button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1000">
                <div class="paginacion">
                    <div class="controles-paginas">
                    <button class="btn btn-tabla btn-first" ng-disabled="configuracion.paginacion.pagina<=1" ng-click="irPagina(1)"></button>
                        <button class="btn btn-tabla btn-prev" ng-disabled="configuracion.paginacion.pagina<=1" ng-click="cambiarPagina(-1)"></button>
                    <input type="number" ng-change="leer()" class="marcador-pagina" min="1" max="{{configuracion.paginacion.total}}"  ng-model="configuracion.paginacion.pagina"/>
                    /{{ configuracion.paginacion.total || 1 }}
                        <button class="btn btn-tabla btn-next" ng-click="cambiarPagina(1)" ng-disabled="configuracion.paginacion.total<=configuracion.paginacion.pagina"></button>
                        <button class="btn btn-tabla btn-prev-last" ng-disabled="configuracion.paginacion.total<=configuracion.paginacion.pagina"
                        ng-click="irPagina(configuracion.paginacion.total)"></button>
                    </div>
                    <div class="resultados-por-pagina">
                        <?php echo ucfirst($idioma("resultados_por_pagina")); ?>
                        <select title="<?php ucfirst($idioma("resultados_por_pagina")); ?>" ng-init='configuracion.paginacion.pageSizes.seleccionado=configuracion.paginacion.pageSizes.seleccionado||configuracion.paginacion.pageSizes.valores[0]'
                            ng-model='configuracion.paginacion.pageSizes.seleccionado'
                            ng-change='leer()'
                            ng-options='rPp.texto for rPp in configuracion.paginacion.pageSizes.valores track by rPp.valor'></select>

                    </div>
                    <div><?php echo $idioma("refresh"); ?><button class="btn btn-tabla btn-actualizar" title="<?php echo ucfirst($idioma("refresh")); ?>" class="btn" ng-click="leer()"></button></div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>