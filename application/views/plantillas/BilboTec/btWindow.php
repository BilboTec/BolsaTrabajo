<div class="bt-window-wrapper" ng-show="visible">
	<div class="bt-window">
		<div class="bt-window-titulo" ng-show="titulo">
				{{ titulo }}
		</div>
		<div class="bt-window-texto" ng-show="!url">
			{{contenido}}
		</div>
		<div class="bt-window-url" ng-show="url" ng-inclide="url"></div>
		<div class="bt-window-btn-container">
			<button ng-repeat="boton in botones" ng-click="boton.accion()">{{boton.texto | btLocale | capitalize}}</button>
		</div>
	</div>
</div>