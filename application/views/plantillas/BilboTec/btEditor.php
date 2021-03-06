	<ul class="barra-comandos">
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('undo')"><img alt="<?php echo ucfirst($idioma("deshacer")); ?>" title="<?php echo ucfirst($idioma("deshacer")); ?>" src="/imagenes/editor/undo1.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('redo')"><img alt="<?php echo ucfirst($idioma("rehacer")); ?>" title="<?php echo ucfirst($idioma("rehacer")); ?>" src="/imagenes/editor/redo.png"/></li>
		</ul>
	</li>
	<li>
		<ul ng-model="parrafo" class="parrafo">
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h1')">h1</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h2')">h2</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h3')">h3</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h4')">h4</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h5')">h5</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','h6')">h6</li>
			<li class="btn btn-tipo" ng-click="comando($event,'formatBlock','p')">p</li>
		</ul>
	</li>
	<ul>
		<select ng-model="fn" ng-change="comando($event,'fontName',fn)">
			<option ng-repeat="fuente in fuentes" value={{fuente}}>{{fuente}}</option>
		</select>
		<select ng-model="tam" ng-change="comando($event,'fontSize',tam)">
			<option ng-repeat="t in [1,2,3,4,5,6,7]" value={{t}}>{{t}}</option>
		</select>
	</ul>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando($event,'italic')" ng-class="italic?'activo':''"><img alt="<?php echo ucfirst($idioma("cursiva")); ?>" title="<?php echo ucfirst($idioma("cursiva")); ?>" src="/imagenes/editor/italic.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'bold')" ng-class="bold?'activo':''"><img alt="<?php echo ucfirst($idioma("negrita")); ?>" title="<?php echo ucfirst($idioma("negrita")); ?>" src="/imagenes/editor/bold.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'underline')" ng-class="underline?'activo':''"><img alt="<?php echo ucfirst($idioma("subrayado")); ?>" title="<?php echo ucfirst($idioma("subrayado")); ?>" src="/imagenes/editor/underline.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando($event,'justifyLeft')"><img alt="<?php echo ucfirst($idioma("alinear_izq")); ?>" title="<?php echo ucfirst($idioma("alinear_izq")); ?>" src="/imagenes/editor/jleft.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'justifyCenter')"><img alt="<?php echo ucfirst($idioma("centrar")); ?>" title="<?php echo ucfirst($idioma("centrar")); ?>" src="/imagenes/editor/jcenter.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'justifyFull')"><img alt="<?php echo ucfirst($idioma("justificar")); ?>" title="<?php echo ucfirst($idioma("justificar")); ?>" src="/imagenes/editor/just.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'justifyRight')"><img alt="<?php echo ucfirst($idioma("alinear_der")); ?>" title="<?php echo ucfirst($idioma("alinear_der")); ?>" src="/imagenes/editor/jright.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando($event,'outdent')"><img alt="<?php echo ucfirst($idioma("disminuir_sangria")); ?>" title="<?php echo ucfirst($idioma("disminuir_sangria")); ?>" src="/imagenes/editor/ind.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'indent')"><img alt="<?php echo ucfirst($idioma("aumentar_sangria")); ?>" title="<?php echo ucfirst($idioma("aumentar_sangria")); ?>" src="/imagenes/editor/out.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando($event,'copy')"><img alt="<?php echo ucfirst($idioma("copiar")); ?>" title="<?php echo ucfirst($idioma("copiar")); ?>" src="/imagenes/editor/copy.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'cut')"><img alt="<?php echo ucfirst($idioma("cortar")); ?>" title="<?php echo ucfirst($idioma("cortar")); ?>" src="/imagenes/editor/cut.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'paste')"><img alt="<?php echo ucfirst($idioma("pegar")); ?>" title="<?php echo ucfirst($idioma("pegar")); ?>" src="/imagenes/editor/paste.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando($event,'insertOrderedList')"><img alt="<?php echo ucfirst($idioma("lista_numerada")); ?>" title="<?php echo ucfirst($idioma("lista_numerada")); ?>" src="/imagenes/editor/ord.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'insertUnorderedList')"><img alt="<?php echo ucfirst($idioma("lista")); ?>" title="<?php echo ucfirst($idioma("lista")); ?>" src="/imagenes/editor/unord.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="link()"><img alt="<?php echo ucfirst($idioma("hipervinculo")); ?>" title="<?php echo ucfirst($idioma("hipervinculo")); ?>" src="/imagenes/editor/link.png"/></li>
			<li class="btn btn-tipo" ng-click="comando($event,'unlink')"><img alt="<?php echo ucfirst($idioma("quitar_hipervinculo")); ?>" title="<?php echo ucfirst($idioma("quitar_hipervinculo")); ?>" src="/imagenes/editor/unlink.png"/></li>
		</ul>
	</li>
</ul>
<div bt-window="ventana"/>
<input type="hidden"  value="{{valor}}">
<iframe ng-keypress="actualizar()">
	
</iframe>