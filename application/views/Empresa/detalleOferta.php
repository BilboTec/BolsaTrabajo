<div ng-if="!editando">
	<div class="grupo-horizontal">
			<h1>{{oferta.titulo | uppercase}}</h1>
			<span class="btn btn-tipo" ng-click="editar()"> <?php echo mb_ucfirst($idioma("editar")); ?></span>
	</div>
	<p>Publicada hace {{ oferta.fecha | diferencia_fecha}}</p>
	<div ng-model="oferta.descripcion" bt-contenido-html></div>
	<div ng-model="oferta.requisitos" bt-contenido-html></div>
	<p>{{ oferta.estusion_min}}</p>
	<p>{{ oferta.experencia_min}}</p>
	<p>{{ oferta.horario}}</p>
	<p>{{ oferta.salario}}</p>
	<div>
		<h2><?php echo ucfirst($idioma("conocimientos")); ?></h2>
		<p ng-repeat="conocimiento in oferta.conocimientos">{{ conocimiento.nombre }}</p>
	</div>
	<p>{{ (oferta.visible!=="0"?'Publica':'Privada') }}</p>
</div>

<div ng-if="editando" class="grupo">
	<h1 class="titulo"><?php echo strtoupper($idioma("editar_oferta")); ?></h1>
	<div class="grupo">
	<label>Titulo</label>
	<input ng-model="vista.titulo"/>
	</div>
	
	<div class="grupo">
	<label>Estudios minimos</label>
	<input type="text" ng-model="vista.estudios_min"/>
	</div>
	
	<div class="grupo">
	<label>Experiencia minima</label>
	<input type="text" ng-model="vista.experiencia_min"/>
	</div>
	
	<div class="grupo">
	<label>Requisitos</label>
	<div bt-editor ng-model="vista.requisitos"></div>
	</div>
	
	<div class="grupo">
	<label>Descripción</label>
	<div bt-editor="editor" ng-model="vista.descripcion"></div>
	</div>
	
	<div class="grupo">
	<label>Horario</label>
	<input type="text" ng-model="vista.horario"/>
	</div>
	
	<div class="grupo">
	<label>Salario</label>
	<input type="text" ng-model="vista.salario"/>
	</div>
	<div class="grupo">
		<label for="conocimientos"><?php echo ucfirst("conocimientos"); ?></label>
		<div id="conocimientos" ng-model="vista.conocimientos" bt-auto-complete="autoCompleteConocimientos"  bt-texto="nombre" bt-clave="id_conocimiento" bt-url="/api/Conocimientos/Like"></div>
	</div>
	<div class="grupo">
	<label>Publico<input type="checkbox" ng-true-value="'1'" ng-false-value="'0'" ng-model="vista.visible"></label>
	</div>
	
	<span class="btn-tipo btn" ng-click="guardar()"><?php echo ucfirst($idioma("guardar")); ?></span>
</div>
	<ul ng-if="!editando"> 
		<li ng-if="alumnos.length == 0"><?php echo mb_ucfirst($idioma("no_alumnos_apuntados")); ?></li>
		<li ng-if="alumnos.length" ng-repeat="alumno in alumnos">
			<a target="_blank" ng-href="/api/Alumnos/Curriculum/{{alumno.id_alumno}}">{{alumno.nombre}} {{alumno.apellido1}} {{alumno.apellido2}}</a>
		</li>
	</ul>
	<a href="#!/"><?php echo ucfirst($idioma("volver")); ?></a>