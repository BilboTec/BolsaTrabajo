<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="grupo oferta-option filtro-contenedor">
					<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="0"/> <?php echo mb_ucfirst($idioma("cualquier_fecha")); ?></p>
	  				<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="1"/> <?php echo mb_ucfirst($idioma("24_horas")); ?></p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="2"/> <?php echo mb_ucfirst($idioma("7_dias")); ?></p>
					<p><input ng-model="filtros.fecha_oferta" type="radio" name="fecha" value="3"/> <?php echo mb_ucfirst($idioma("15_dias")); ?></p><br>
  		<span class="btn btn-tipo" ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></span>
  		</div>

		</fieldset>
		<a class="centrado verde"href="#!/0"><?php echo mb_ucfirst($idioma("anadir_oferta")); ?><img src="/imagenes/anadir.png"/><a>
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
	