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
<p>{{ (oferta.visible!=="0"?'Publica':'Privada') }}</p>
</div>
<a ng-href="#!/Editar/{{oferta.id_oferta}}">Editar</a>