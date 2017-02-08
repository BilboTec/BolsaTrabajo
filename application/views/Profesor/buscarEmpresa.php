<aside ng-init='espana=<?php echo json_encode($espana); ?>;init()'>
		<fieldset>
			<legend><?php echo strtoupper($idioma('filtro')); ?></legend>
			<div class="filtro-contenedor">
				<div class="grupo">
	  				<label><?php echo ucfirst($idioma('provincia')); ?></label><br>
					<select ng-model='filtros.id_provincia' ng-change="cargarLocalidades()" ng-disabled="provinciasDisabled">
					<?php
					foreach ($provincias as $provincia){
					  echo "<option value= '" .$provincia->id_provincia ."'>" .$provincia->nombre ."</option>";
					}
					?>
					</select>
				</div>
				<div class="grupo">
	  				<label><?php echo ucfirst($idioma('localidad')); ?></label><br>
					<select ng-model='filtros.id_localidad' ng-disabled="provinciasDisabled">
						<option ng-repeat="localidad in localidades" value="{{localidad.id_localidad}}">{{localidad.nombre}}</option>
					</select>
				</div>
				<div class="grupo">
	  				<label><?php echo ucfirst($idioma('pais')); ?></label><br>
					<select ng-model='filtros.id_pais' ng-change="comprobarPais()">
					<?php
					foreach ($paises as $pais){
					  echo "<option value= '" .$pais->id_pais ."'>" .$pais->nombre ."</option>";
					}
					?>
					</select>
				</div>
				
				<div class="grupo">
					<label><?php echo ucfirst($idioma('buscar')); ?></label>
					<input class="buscar" type="text" ng-model="filtros.buscador"/>
				</div>
				<span class="btn btn-tipo" ng-click="buscar()" type="button"><?php echo ucfirst($idioma('filtrar')); ?></span>
			</div>
			
		</fieldset>
		<?php if($es_administrador){ ?>
		<a class="centrado verde" href="#!/AnadirEmpresa"><?php echo mb_ucfirst($idioma("anadir_empresa")); ?><img src="/imagenes/anadir.png"/><a>
		<?php } ?>
	</aside>
	<section>
		<article ng-repeat="empresa in empresas">
		<a ng-href="#!/{{empresa.id_empresa}}">
			<h1>{{empresa.nombre}}</h1>
			<p>{{empresa.email}}</p>
		</a>
		</article>	
		
	</section>
	