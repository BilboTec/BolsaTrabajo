<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
				<input type="radio" name="fecha" value="Cualquier fecha"/> Cualquier fecha<br>
  				<input type="radio" name="fecha" value="Ultimas 24 Horas"/> Ultimas 24 Horas<br>
  				<input type="radio" name="fecha" value="Ultimos 7 dias"/> Ultimos 7 dias<br>
  				<input type="radio" name="fecha" value="Ultimos 15 dias"/> Ultimos 15 dias<br><br>
  				
  				
  				<label><?php echo ucfirst($idioma('departamento')); ?></label><br>
  				
				<select>
				<?php
				foreach ($departamentos as $departamento){
				  echo "<option value= '" .$departamento["nombre"] ."'>" .$departamento["nombre"] ."</option>";
				}
				?>
				</select><br><br>
				
				<input type="submit" value="<?php echo ucfirst($idioma('filtrar')); ?>">
			</div>
			
		</fieldset>
	</aside>
		<section>
			<?php
				foreach ($ofertas as $oferta){
				  echo "<article>";
				  echo "<h1>" .$oferta["titulo"] ."</h1> <p>" .$oferta["descripcion"] ."</p> <div class='opciones'><h5> Estudios minimos " .$oferta["estudios_min"] ."</h5> <h5> Experiencia minima ".$oferta["experiencia_min"] ."</h5> <h5> Horario " .$oferta["horario"] ."</h5> </div>";
				  echo "</article>";
				}
				?>
		
		</section>
	