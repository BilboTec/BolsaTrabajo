<aside>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				
				<label for="conocimientos"><?php echo ucfirst($idioma('conocimientos')); ?></label>
				<div id="conocimientos" ng-model="filtros.conocimientos" bt-clave="id_conocimiento" bt-texto="nombre" bt-url="/api/Conocimientos/Like" bt-auto-complete="completeConocimientos"></div>
				
  				<label><?php echo ucfirst($idioma('oferta_formativa')); ?></label><br>
  				
				<select ng-model='filtros.id_oferta_formativa'>
				<?php
				foreach ($ofertas_formativas as $oferta_formativa){
				  echo "<option value= '" .$oferta_formativa->id_oferta_formativa ."'>" .$oferta_formativa->nombre ."</option>";
				}
				?>
				</select><br><br>
				
				<input type="text" ng-model="filtros.buscador"/>

				<button ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></button>
			</div>
			
		</fieldset>
		<a href="#!/AnadirEmpresa">Añadir Empresa<img src="/imagenes/anadir.png"/><a>
	</aside>
	<section>
		<article ng-repeat="empresa in empresas">
		<a ng-href="#!/{{empresa.id_empresa}}">
			<h1>{{empresa.nombre}}</h1>
			<p>{{empresa.email}}</p>
		</a>
		</article>
			<select ng-model="filtro.resultadosPorPagina">
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					
			</select>
			<input ng-model="filtro.pagina" ng-change="buscar()"/>	
		
	</section>
	