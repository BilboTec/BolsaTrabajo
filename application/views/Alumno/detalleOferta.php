<div>
<h1>{{oferta.titulo | uppercase}}</h1>
<h3>{{oferta.nombre_empresa}}</h3>
<p>Publicada hace {{ oferta.fecha | diferencia_fecha}}</p>
<p>{{ oferta.descripcion }}</p>
<p>{{ oferta.requisitos}}</p>
<p>{{ oferta.estusion_min}}</p>
<p>{{ oferta.experencia_min}}</p>
<p>{{ oferta.horario}}</p>
<p>{{ oferta.salario}}</p>
</div>
<span ng-click="apuntarse()" class="btn btn-tipo" ng-show="!apuntado">Apuntarme</a>
<p ng-show="apuntado">Ya estas apuntado a esta oferta</p>