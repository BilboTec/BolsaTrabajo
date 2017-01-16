<ul class="barra-comandos">
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('undo')"><img alt="<?php echo ucfirst($idioma("deshacer")); ?>" title="<?php echo ucfirst($idioma("deshacer")); ?>" src="/imagenes/editor/undo1.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('redo')"><img alt="<?php echo ucfirst($idioma("rehacer")); ?>" title="<?php echo ucfirst($idioma("rehacer")); ?>" src="/imagenes/editor/redo.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h1')">h1</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h2')">h2</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h3')">h3</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h4')">h4</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h5')">h5</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','h6')">h6</li>
			<li class="btn btn-tipo" ng-click="comando('formatBlock','p')">p</li>
		</ul>
	</li>
	<ul>
		<select ng-model="fn" ng-change="comando('fontName',fn)">
			<option ng-repeat="fuente in fuentes" value={{fuente}}>{{fuente}}</option>
		</select>
		<select ng-model="tam" ng-change="comando('fontSize',tam)">
			<option ng-repeat="t in [1,2,3,4,5,6,7]" value={{t}}>{{t}}</option>
		</select>
	</ul>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('italic')"><img alt="<?php echo ucfirst($idioma("cursiva")); ?>" title="<?php echo ucfirst($idioma("cursiva")); ?>" src="/imagenes/editor/italic.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('bold')"><img alt="<?php echo ucfirst($idioma("negrita")); ?>" title="<?php echo ucfirst($idioma("negrita")); ?>" src="/imagenes/editor/bold.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('underline')"><img alt="<?php echo ucfirst($idioma("subrayado")); ?>" title="<?php echo ucfirst($idioma("subrayado")); ?>" src="/imagenes/editor/underline.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('justifyLeft')"><img alt="<?php echo ucfirst($idioma("alinear_izq")); ?>" title="<?php echo ucfirst($idioma("alinear_izq")); ?>" src="/imagenes/editor/jleft.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyCenter')"><img alt="<?php echo ucfirst($idioma("centrar")); ?>" title="<?php echo ucfirst($idioma("centrar")); ?>" src="/imagenes/editor/jcenter.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyFull')"><img alt="<?php echo ucfirst($idioma("justificar")); ?>" title="<?php echo ucfirst($idioma("justificar")); ?>" src="/imagenes/editor/just.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyRight')"><img alt="<?php echo ucfirst($idioma("alinear_der")); ?>" title="<?php echo ucfirst($idioma("alinear_der")); ?>" src="/imagenes/editor/jright.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('indent')"><img alt="<?php echo ucfirst($idioma("disminuir_sangria")); ?>" title="<?php echo ucfirst($idioma("disminuir_sangria")); ?>" src="/imagenes/editor/ind.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('outdent')"><img alt="<?php echo ucfirst($idioma("aumentar_sangria")); ?>" title="<?php echo ucfirst($idioma("aumentar_sangria")); ?>" src="/imagenes/editor/out.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('copy')"><img alt="<?php echo ucfirst($idioma("copiar")); ?>" title="<?php echo ucfirst($idioma("copiar")); ?>" src="/imagenes/editor/copy.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('cut')"><img alt="<?php echo ucfirst($idioma("cortar")); ?>" title="<?php echo ucfirst($idioma("cortar")); ?>" src="/imagenes/editor/cut.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('paste')"><img alt="<?php echo ucfirst($idioma("pegar")); ?>" title="<?php echo ucfirst($idioma("pegar")); ?>" src="/imagenes/editor/paste.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('insertOrderedList')"><img alt="<?php echo ucfirst($idioma("lista_numerada")); ?>" title="<?php echo ucfirst($idioma("lista_numerada")); ?>" src="/imagenes/editor/ord.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('insertUnorderedList')"><img alt="<?php echo ucfirst($idioma("lista")); ?>" title="<?php echo ucfirst($idioma("lista")); ?>" src="/imagenes/editor/unord.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="link()"><img alt="<?php echo ucfirst($idioma("hipervinculo")); ?>" title="<?php echo ucfirst($idioma("hipervinculo")); ?>" src="/imagenes/editor/link.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('unlink')"><img alt="<?php echo ucfirst($idioma("quitar_hipervinculo")); ?>" title="<?php echo ucfirst($idioma("quitar_hipervinculo")); ?>" src="/imagenes/editor/unlink.png"/></li>
		</ul>
	</li>
</ul>
<div bt-window="ventana"/>
<input type="hidden"  value="{{valor}}">
<iframe ng-keypress="actualizar()">
	
</iframe>