<ul class="barra-comandos">
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('undo')"><img src="/imagenes/editor/undo.png"/></li>
			<li class="btn btn-tipo" ng-click="comando('redo')">Reh</li>
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
			<li class="btn btn-tipo" ng-click="comando('italic')"><i>K</i></li>
			<li class="btn btn-tipo" ng-click="comando('bold')"><b>N</b></li>
			<li class="btn btn-tipo" ng-click="comando('underline')"><u>S</u></li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('justifyLeft')">Izq</li>
			<li class="btn btn-tipo" ng-click="comando('justifyCenter')">Cent</li>
			<li class="btn btn-tipo" ng-click="comando('justifyFull')">Just</li>
			<li class="btn btn-tipo" ng-click="comando('justifyRight')">Der</li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('indent')">Ind</li>
			<li class="btn btn-tipo" ng-click="comando('outdent')">Out</li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('copy')">Copiar</li>
			<li class="btn btn-tipo" ng-click="comando('cut')">cortar</li>
			<li class="btn btn-tipo" ng-click="comando('paste')">Pegar</li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="comando('insertOrderedList')">Ord</li>
			<li class="btn btn-tipo" ng-click="comando('insertUnorderedList')">Unord</li>
		</ul>
	</li>
	<li>
		<ul>
			<li class="btn btn-tipo" ng-click="link()">Link</li>
			<li class="btn btn-tipo" ng-click="comando('unlink')">Unlink</li>
		</ul>
	</li>
</ul>
<div bt-window="ventana"/>
<input type="hidden"  value="{{valor}}">
<iframe ng-keypress="actualizar()">
	
</iframe>