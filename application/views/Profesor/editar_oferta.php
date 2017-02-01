<div class="grupo">
	<h1 class="titulo"><?php echo strtoupper($idioma("editar_oferta")); ?></h1>
	<div class="grupo">
	<label>Titulo</label>
	<input ng-model="oferta.titulo"/>
	</div>
	
	<div class="grupo">
	<label>Nombre Empresa</label>
	<input ng-model="oferta.nombre_empresa"/>
	</div>
	
	<div class="grupo">
	<label>Estudios minimos</label>
	<input type="text" ng-model="oferta.estudios_min"/>
	</div>
	
	<div class="grupo">
	<label>Experiencia minima</label>
	<input type="text" ng-model="oferta.experiencia_min"/>
	</div>
	
	<div class="grupo">
	<label>Requisitos</label>
	<div bt-editor ng-model="oferta.requisitos"></div>
	</div>
	
	<div class="grupo">
	<label>Descripción</label>
	<div bt-editor="editor" ng-model="oferta.descripcion"></div>
	</div>
	
	<div class="grupo">
	<label>Horario</label>
	<input type="text" ng-model="oferta.horario"/>
	</div>
	
	<div class="grupo">
	<label>Salario</label>
	<input type="text" ng-model="oferta.salario"/>
	</div>
	<div class="grupo">
		<label for="conocimientos"><?php echo ucfirst("conocimientos"); ?></label>
		<div id="conocimientos" ng-model="oferta.conocimientos" bt-auto-complete="autoCompleteConocimientos"  bt-texto="nombre" bt-clave="id_conocimiento" bt-url="/api/Conocimientos/Like"></div>
	</div>
	<div class="grupo">
	<label>Publico<input type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-model="oferta.visible"></label>
	</div>
	
	<span class="btn-tipo btn" ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></span>
	<a ng-href="#!/{{oferta.id_oferta==0?'':oferta.id_oferta}}"><?php echo ucfirst($idioma("volver")); ?></a>
</div>