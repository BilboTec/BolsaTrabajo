
<div class="cont-oferta-profe todo">
		<div class="grupo-horizontal">
			<div class="grupo-vertical todo">
				<div class="grupo-horizontal">
				<h1>{{oferta.titulo | uppercase}}</h1>
				<?php
				if(isset($puedeEditar) && $puedeEditar){
					echo '<a class="btn btn-tipo" ng-href="#!/Editar/{{oferta.id_oferta}}">Editar</a>';
					echo "<span class='btn btn-tipo' ng-click='eliminar()'>Eliminar</span>";
				}
				?>
				</div>
				<div bt-window="ventana"></div>
				<h3>{{oferta.nombre_empresa}}</h3>
				<p>Publicada hace {{ oferta.fecha | diferencia_fecha}}</p>
				<div ng-model="oferta.descripcion" bt-contenido-html></div>
				<div ng-model="oferta.requisitos" bt-contenido-html></div>
				<p>{{ oferta.estudios_min}}</p>
				<p>{{ oferta.experencia_min}}</p>
				<p>{{ oferta.horario}}</p>
				<p>{{ oferta.salario}}</p>
				<h2><?php echo ucfirst($idioma("conocimientos")); ?></h2>
				<p ng-repeat="conocimiento in oferta.conocimientos">{{ conocimiento.nombre }}</p>
				<p>{{ (oferta.visible!=="0"?'Publica':'Privada') }}</p>
			</div>
			<?php if(!$es_user) { ?>
			<div bt-buscador-alumnos ng-model="oferta"></div>
			<?php } ?>
		</div>

<a class="verde" href="#!/"><?php echo ucfirst($idioma("volver")); ?> </a>
</div>
