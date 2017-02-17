<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<div class="grupo oferta-option">
					<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="0"/> <?php echo mb_ucfirst($idioma("cualquier_fecha")); ?></p>
	  				<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="1"/> <?php echo mb_ucfirst($idioma("24_horas")); ?></p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="2"/> <?php echo mb_ucfirst($idioma("7_dias")); ?></p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="3"/> <?php echo mb_ucfirst($idioma("15_dias")); ?></p><br>
  				</div>
  				
  				<div class="grupo">
					<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
					<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Like" bt-auto-complete="completeConocimientos"></div>
				</div>
				
				<div class="grupo">
					<label><?php echo ucfirst($idioma('buscar')); ?></label>
					<input class="buscar" type="text" ng-model="filtros.buscador"/>
				</div>
				<span class="btn btn-tipo" ng-click="buscar()"><?php echo ucfirst($idioma('filtrar')); ?></span>
			</div>	
		</fieldset>
	</aside>
	<section>
		<article ng-repeat="oferta in ofertas">
		<a ng-href="#!/{{oferta.id_oferta}}">
			<h1>{{oferta.titulo}}</h1>
			<p>{{oferta.descripcion}}</p>
			<div class="opciones">
				<h5 ng-show="oferta.estudios_min">Estudios minimos {{oferta.estudios_min}}</h5>
				<h5 ng-show="oferta.experiencia_min">Experiencia minima {{oferta.experiencia_min}}</h5>
				<h5 ng-show="oferta.horario">Horario {{oferta.horario}}</h5>
			</div>
		</a>
		</article>

	</section>
	