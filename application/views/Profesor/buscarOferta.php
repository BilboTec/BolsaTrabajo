<div ng-controller="filtrat">
<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
				<input ng-model="filtro-fecha" type="radio" name="fecha" value="Cualquier fecha"/> Cualquier fecha<br>
  				<input ng-model="filtro-fecha" type="radio" name="fecha" value="Ultimas 24 Horas"/> Ultimas 24 Horas<br>
  				<input ng-model="filtro-fecha" type="radio" name="fecha" value="Ultimos 7 dias"/> Ultimos 7 dias<br>
  				<input ng-model="filtro-fecha" type="radio" name="fecha" value="Ultimos 15 dias"/> Ultimos 15 dias<br><br>
  				
  				
  				<label><?php echo ucfirst($idioma('departamento')); ?></label><br>
  				
				<select>
				<?php
				foreach ($departamentos as $departamento){
				  echo "<option ng-model='filtro-departamento' value= '" .$departamento["nombre"] ."'>" .$departamento["nombre"] ."</option>";
				}
				?>
				</select><br><br>
				
				<input ng-change="buscar()" type="submit" value="<?php echo ucfirst($idioma('filtrar')); ?>">
			</div>
			
		</fieldset>
	</aside>
	<section ng-repeat="oferta in ofertas">
		<article>
			<h1>{{oferta.titulo}}</h1>
			<p>{{oferta.descripcion}}</p>
			<div class="opciones">
				<h5>Estudios minimos {{oferta.estudios_min}}</h5>
				<h5>Experiencia minima {{oferta.experiencia_min}}</h5>
				<h5>Horario {{oferta.horario}}</h5>
			</div>
		</article>
			
			<!--<?php
				foreach ($ofertas as $oferta){
				  echo "<article>";
				  echo "<h1>" .$oferta["titulo"] ."</h1> <p>" .$oferta["descripcion"] ."</p> <div class='opciones'><h5> Estudios minimos " .$oferta["estudios_min"] ."</h5> <h5> Experiencia minima ".$oferta["experiencia_min"] ."</h5> <h5> Horario " .$oferta["horario"] ."</h5> </div>";
				  echo "</article>";
				}
				?>-->
		
	</section>
</div>
	<script>
		angular.module(“Bilbotec”).controller(“filtrar”,[“$scope”,”$http”,function($scope,$http){
		$scope.filtros = {
			
		};
		}]);
		$scope.buscar = function(){
			$http({url:"/api/Profesor/buscarOferta/",params:filtros)
			.then(
				function(respuesta){ 
				/* asigna la respuesta a la colección que muestras en el ng-
				repeat*/
				$scope.ofertas = respuesta.consulta;
				},
				function(error){
					alert(error.data?error.data:error);
				}
			)
		}
	</script>
	