<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<label><?php echo ucfirst($idioma('fecha')); ?></label><br>
				<input type="radio" name="fecha" value="Cualquier fecha"> Cualquier fecha<br>
  				<input type="radio" name="fecha" value="Ultimas 24 Horas"> Ultimas 24 Horas<br>
  				<input type="radio" name="fecha" value="Ultimos 7 dias"> Ultimos 7 dias<br>
  				<input type="radio" name="fecha" value="Ultimos 15 dias"> Ultimos 15 dias<br><br>
  				
  				
  				<label><?php echo ucfirst($idioma('departamento')); ?></label><br>
				<select>
				  <option value="informatica">Informática</option>
				  <option value="comercio">Comercio</option>
				  <option value="quimica">Química</option>
				  <option value="electronica">Electrónica</option>
				</select><br>
				
				<input type="submit" value="<?php echo ucfirst($idioma('filtrar')); ?>">

			</div>
		</fieldset>
		<section>
		
		</section>
	</aside>