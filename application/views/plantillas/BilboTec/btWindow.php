<div class="bt-window-wrapper" ng-if="visible">
	<div class="bt-window" ng-show="visible">
		<div class="bt-window-titulo" ng-show="titulo">
				{{ titulo | btLocale | capitalize }}
		</div>
		<div class="bt-window-texto" ng-show="!url">
			{{ contenido | btLocale | capitalize }}
		</div>
		<div class="bt-window-url" ng-show="url" ng-include="url"></div>
		<div class="bt-window-btn-container">
			<span class="btn btn-tipo" ng-repeat="boton in botones" ng-click="boton.accion()">{{boton.texto | btLocale | capitalize}}</button>
		</div>
	</div>
</div>