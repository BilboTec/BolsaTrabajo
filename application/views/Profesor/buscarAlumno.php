<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
				<input ng-model="filtro.fecha" type="radio" name="fecha" value="Cualquier fecha"/> Cualquier fecha<br>
  				<input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimas 24 Horas"/> Ultimas 24 Horas<br>
  				<input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimos 7 dias"/> Ultimos 7 dias<br>
  				<input ng-model="filtro.fecha" type="radio" name="fecha" value="Ultimos 15 dias"/> Ultimos 15 dias<br><br>
  				
  				
  				<label><?php echo ucfirst($idioma('departamento')); ?></label><br>
  				
				<select>
				<?php
				foreach ($departamentos as $departamento){
				  echo "<option ng-model='filtro.departamento' value= '" .$departamento->id_departamento ."'>" .$departamento->nombre ."</option>";
				}
				?>
				</select><br><br>

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
	