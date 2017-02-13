<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<div class="grupo oferta-option">
					<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="0"/> Cualquier fecha</p>
	  				<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="1"/> Ultimas 24 Horas</p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="2"/> Ultimos 7 dias</p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="3"/> Ultimos 15 dias</p>
  				</div>
  				
  				<div class="grupo">
					<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
					<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Like" bt-auto-complete="completeConocimientos"></div>
				</div>
				
				<div class="grupo">
					<label><?php echo ucfirst($idioma('buscar')); ?></label>
					<input class="buscar" type="text" ng-model="filtros.buscador"/>
				</div>
				<span class="btn btn-tipo" ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></span>
			</div>
			
		</fieldset>
		<?php if($es_administrador){ ?>
		<a class="centrado verde" href="#!/Editar/0"><?php echo ucfirst($idioma('anadir_oferta')); ?><img src="/imagenes/anadir.png"/><a>
		<?php } ?>
	</aside>
	<section>
		<article ng-repeat="oferta in ofertas">
		<a ng-href="#!/{{oferta.id_oferta}}">
			<h1>{{oferta.titulo}}</h1>
			<div ng-model="oferta.descripcion" bt-contenido-html></div>
			<div class="opciones">
				<h5 ng-show="oferta.estudios_min">Estudios minimos {{oferta.estudios_min}}</h5>
				<h5 ng-show="oferta.experiencia_min">Experiencia minima {{oferta.experiencia_min}}</h5>
				<h5 ng-show="oferta.horario">Horario {{oferta.horario}}</h5>
			</div>
		</a>
		</article>
		<article ng-if="ofertas.length === 0">
			<h1>No se han encontrado resultados</h1>
		</article>
	</section>
	