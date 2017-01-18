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
	<textarea ng-model="oferta.estudios_min"></textarea>
	</div>
	
	<div class="grupo">
	<label>Experiencia minima</label>
	<textarea ng-model="oferta.experiencia_min"></textarea>
	</div>
	
	<div class="grupo">
	<label>Requisitos</label>
	<textarea ng-model="oferta.requisitos"></textarea>
	</div>
	
	<div class="grupo">
	<label>Descripción</label>
	<div bt-editor="editor" ng-model="oferta.descripcion"></div>
	</div>
	
	<div class="grupo">
	<label>Horario</label>
	<textarea ng-model="oferta.horario"></textarea>
	</div>
	
	<div class="grupo">
	<label>Salario</label>
	<textarea ng-model="oferta.salario"></textarea>
	</div>
	
	<div class="grupo">
	<label>Publico<input type="checkbox" ng-model="oferta.visible"></label>
	</div>
	
	<span class="btn-tipo btn" ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></span>
	<a ng-href="#!/{{oferta.id_oferta==0?'':oferta.id_oferta}}">Volver</a>
</div>