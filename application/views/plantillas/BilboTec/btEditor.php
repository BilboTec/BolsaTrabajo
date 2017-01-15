<ul class="barra-comandos">
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('undo')"><img src="/imagenes/editor/undo1.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('redo')"><img src="/imagenes/editor/redo.png"/></li>
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
			<li class="btn btn-tipo" ng-click="comando('italic')"><img src="/imagenes/editor/italic.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('bold')"><img src="/imagenes/editor/bold.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('underline')"><img src="/imagenes/editor/underline.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('justifyLeft')"><img src="/imagenes/editor/jleft.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyCenter')"><img src="/imagenes/editor/jcenter.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyFull')"><img src="/imagenes/editor/just.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('justifyRight')"><img src="/imagenes/editor/jright.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('indent')"><img src="/imagenes/editor/ind.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('outdent')"><img src="/imagenes/editor/out.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('copy')"><img src="/imagenes/editor/copy.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('cut')"><img src="/imagenes/editor/cut.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('paste')"><img src="/imagenes/editor/paste.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('insertOrderedList')"><img src="/imagenes/editor/ord.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('insertUnorderedList')"><img src="/imagenes/editor/unord.png"/></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="link()"><img src="/imagenes/editor/link.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('unlink')"><img src="/imagenes/editor/unlink.png"/></li>
		</ul>
	</li>
</ul>
<div bt-window="ventana"/>
<input type="hidden"  value="{{valor}}">
<iframe ng-keypress="actualizar()">
	
</iframe>