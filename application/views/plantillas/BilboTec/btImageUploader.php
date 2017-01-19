<canvas id="canvas">
</canvas height="200" width="160">
<input type="file" accept="image/*"/>

<div class="grupo-horizontal">
		<input id="offsetX" type="number" ng-model="offset.x" ng-change="imagenSeleccionada()"/>
		<input id="offsetY" type="number" ng-model="offset.y" ng-change="imagenSeleccionada()"/>
		<input id="scale" type="number" ng-model="scale" ng-change="imagenSeleccionada()"/>
</div>

<p ng-show="size"><?php echo ucfirst($idioma("tamano")); ?>: {{ size }}</p>
<input type="hidden"  value="{{ imagen }}"/>
