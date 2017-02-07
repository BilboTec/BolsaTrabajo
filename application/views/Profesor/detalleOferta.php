<div class="cont-oferta-profe">
<div class="grupo-horizontal">
		<h1>{{oferta.titulo | uppercase}}</h1>
		<?php 
			if(isset($puedeEditar) && $puedeEditar){
				echo '<a class="btn btn-tipo" ng-href="#!/Editar/{{oferta.id_oferta}}">Editar</a>';
			}
		?>
</div>
<h3>{{oferta.nombre_empresa}}</h3>
<p>Publicada hace {{ oferta.fecha | diferencia_fecha}}</p>
<div ng-model="oferta.descripcion" bt-contenido-html></div>
<div ng-model="oferta.requisitos" bt-contenido-html></div>
<p>{{ oferta.estusion_min}}</p>
<p>{{ oferta.experencia_min}}</p>
<p>{{ oferta.horario}}</p>
<p>{{ oferta.salario}}</p>
<div>
	<h2><?php echo ucfirst($idioma("conocimientos")); ?></h2>
	<p ng-repeat="conocimiento in oferta.conocimientos">{{ conocimiento.nombre }}</p>
</div>
<p>{{ (oferta.visible!=="0"?'Publica':'Privada') }}</p>
</div>
<div bt-buscador-alumnos ng-model="oferta"></div>
<a href="#!/"><?php echo ucfirst($idioma("volver")); ?> </a>
