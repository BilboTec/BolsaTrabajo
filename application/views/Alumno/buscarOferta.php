<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
				<p><input ng-model="filtro.fecha" type="radio" name="fecha" value="Cualquier fecha"/> Cualquier fecha</p>
  				<p><input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimas 24 Horas"/> Ultimas 24 Horas</p>
  				<p><input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimos 7 dias"/> Ultimos 7 dias</p>
  				<p><input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimos 15 dias"/> Ultimos 15 dias</p><br>
  				
  				<div class="grupo">
	  				<label><?php echo ucfirst($idioma('departamento')); ?></label><br>			
					<select>
					<?php
					foreach ($departamentos as $departamento){
					  echo "<option ng-model='filtro.departamento' value= '" .$departamento["nombre"] ."'>" .$departamento["nombre"] ."</option>";
					}
					?>
					</select>
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
	