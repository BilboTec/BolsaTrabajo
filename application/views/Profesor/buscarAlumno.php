<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				
				<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
				<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Get" bt-auto-complete="completeConocimientos"></div>
				
  				<label><?php echo ucfirst($idioma('oferta_formativa')); ?></label><br>
  				
				<select ng-model='filtros.id_oferta_formativa'>
				<?php
				foreach ($ofertas_formativas as $oferta_formativa){
				  echo "<option value= '" .$oferta_formativa->id_oferta_formativa ."'>" .$oferta_formativa->nombre ."</option>";
				}
				?>
				</select><br><br>
				
				<label><?php echo ucfirst($idioma('fecha_fin_estudios')); ?></label>
				<div bt-date-picker ng-model="filtros.fecha_fin"></div>
				
				<input type="text" ng-model="filtros.buscador"/>

				<button ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></button>
			</div>
			
		</fieldset>
		<a href="#!/InvitarAlumnos">Invitar Alumnos <img src="/imagenes/invitar_alumno.png"/><a>
	</aside>
	<section>
		<article ng-repeat="alumno in alumnos">
		<a ng-href="#!/{{alumno.id_alumno}}">
			<h1>{{alumno.nombre + " " + alumno.apellido1 + " " + alumno.apellido2 }}</h1>
			<p>{{alumno.email}}</p>
		</a>
		</article>
			<select ng-model="filtro.resultadosPorPagina">
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					
			</select>
			<input ng-model="filtro.pagina" ng-change="buscar()"/>	
		
	</section>
	