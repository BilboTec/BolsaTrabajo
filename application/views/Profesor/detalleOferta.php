<div class="detalle_oferta_profesor">

<label>Titulo</label>
<input ng-model="oferta.titulo"/><br>

<label>Nombre Empresa</label>
<input ng-model="oferta.nombre_empresa"/>

<label>Estudios minimos</label>
<textarea ng-model="oferta.estudios_min"></textarea>

<label>Experiencia minima</label>
<textarea ng-model="oferta.experiencia_min"></textarea>

<label>Requisitos</label>
<textarea ng-model="oferta.requisitos"></textarea>

<label>Descripción</label>
<textarea ng-model="oferta.descripcion"></textarea>

<label>Horario</label>
<textarea ng-model="oferta.horario"></textarea>

<label>Salario</label>
<textarea ng-model="oferta.salario"></textarea>

<label>Publico<input type="checkbox" ng-model="oferta.visible"></label>

<a href="#!/">Volver</a>
<button ng-click="guardar()">Guardar</button>
</div>