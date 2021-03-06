<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<div class="grupo">
					<label>Que cumplan</label>
					<div class="grupo-horizontal">
						<p><input type="radio" id="todos" ng-checked="filtros.alguno==0" name="opcion" ng-value="0" ng-model="filtros.alguno"/>Todos</p>
						<p><input type="radio" name="opcion" ng-checked="filtros.alguno==1" ng-value="1" ng-model="filtros.alguno"/>Alguno</p>
					</div>
				</div>
				<div class="grupo">
					<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
					<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Like" bt-auto-complete="completeConocimientos"></div>
				</div>
				
				<div class="grupo">
	  				<label><?php echo ucfirst($idioma('oferta_formativa')); ?></label><br>
					<select ng-model='filtros.id_oferta_formativa'>
						<option></option>
					<?php
					foreach ($ofertas_formativas as $oferta_formativa){
					  echo "<option value= '" .$oferta_formativa->id_oferta_formativa ."'>" .$oferta_formativa->nombre ."</option>";
					}
					?>
					</select>
				</div>
				<div class="grupo">
					<label><?php echo ucfirst($idioma('fecha_fin_estudios')); ?></label>
					<div bt-date-picker ng-model="filtros.fecha_fin"></div>
				</div>
				
				<div class="grupo">
					<label><?php echo ucfirst($idioma('buscar')); ?></label>
					<input class="buscar" type="text" ng-model="filtros.buscador"/>
				</div>
				<span class="btn btn-tipo" ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></span>
			</div>
			
		</fieldset>
		<?php
		if(!$es_user){ ?>
			<a class="centrado verde" href="#!/InvitarAlumnos">Invitar Alumnos <img src="/imagenes/invitar_alumno.png"/><a>
		<?php } ?>
	</aside>
	<section>
		<article ng-repeat="alumno in alumnos">
		<a ng-href="#!/{{alumno.id_alumno}}">
			<h1>{{alumno.nombre}} {{alumno.apellido1}} {{alumno.apellido2 }}</h1>
			<p>{{alumno.email}}</p>
		</a>
		</article>
	</section>
	